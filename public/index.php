<?php
use CRM\Key;
use CRM\Refund;
use CRM\SecretParams;
use CRM\JsonSender;
use Plagins\Security;
use Phalcon\Dispatcher;
use Phalcon\Config;
use Plagins\Mail;
use Plagins\CustomFlash;
try {
	
	$config = new Config(array(
			'mail' => array(
				'fromName' => 'CRM',
				'fromEmail' => 'for_communication@ukr.net',
				'smtp' => array(
					'server' => 'smtp.ukr.net',
					'port' => '465',
					'security' => 'ssl',
					'username' => 'for_communication@ukr.net',
					'password' => 'BwsgSan1'
				)
			)
		)
	);
	
	
	
    //Register an autoloader
    $loader = new \Phalcon\Loader();
    $loader->registerDirs(array(
        '../app/controllers/',
        '../app/models/'
    ));
	
	$loader->registerNamespaces(
		array(
			'CRM' => '../app/models/',
            'Plagins' => '../app/plugins/'
		)
	);
	
	//require_once __DIR__ . '/../vendor/autoload.php';
	
	
	$loader->register();
	
    //Create a DI
    $di = new Phalcon\DI\FactoryDefault();
	
	$di->set('config', $config);
	
	$di->set('mail', function () {
		return new Mail();
	});
	
    $di->set('view', function(){
        $view = new \Phalcon\Mvc\View();
        $view->setViewsDir('../app/views/');
        return $view;
    });



    $di->setShared('session', function() {
        $session = new Phalcon\Session\Adapter\Files();
        $session->start();
        return $session;
    });

    $di->set('flashSession', function(){
        $flash = new CustomFlash();

        $flash->setCssClasses(
            array(
                'error' => 'alert alert-danger' ,
                'success' => 'alert alert-success' ,
                'notice' => 'alert alert-warning' ,
            )
        );
        return $flash;
    });
    //Handle the request

    $di->set('dispatcher', function() use ($di) {

        // Получаем стандартный менеджер событий с помощью DI
        $eventsManager = $di->getShared('eventsManager');

        // Инстанцируем плагин безопасности
        $security = new Security($di);

        // Плагин безопасности слушает события, инициированные диспетчером


        $eventsManager->attach(
            "dispatch:beforeException",
            function($event, $dispatcher, $exception) {

            switch ($exception->getCode()) {
                case Dispatcher::EXCEPTION_HANDLER_NOT_FOUND:
                case Dispatcher::EXCEPTION_ACTION_NOT_FOUND:
                    $dispatcher->forward(array(
                        'controller' => 'index',
                        'action' => 'page404'
                    ));
                    return false;
            }
        });

        $eventsManager->attach('dispatch', $security);

        $dispatcher = new Phalcon\Mvc\Dispatcher();

        // Связываем менеджер событий с диспетчером
        $dispatcher->setEventsManager($eventsManager);

        return $dispatcher;
    }, true
    );

    $di->set('acl', function() use ($di) {
        $acl = new Phalcon\Acl\Adapter\Memory();
        // Действием по умолчанию будет запрет
        $acl->setDefaultAction(Phalcon\Acl::DENY);

// Регистрируем две роли. Users - это зарегистрированные пользователи,
// а Guests - неидентифицированные посетители.
        $roles = array(
            'users' => new Phalcon\Acl\Role('Users'),
            'guests' => new Phalcon\Acl\Role('Guests')
        );
        foreach ($roles as $role) {
            $acl->addRole($role);
        }

        $publicResources = array(
            'index' => array('index','page404'),
            'aut' => array('index','aut'),
            'registration' => array('index', 'register'),
			'refund' => array('add','receiveResponse'),
			'order' => array('add'),
            'user' => array('add','activation')
        );

        $privateResources = array(
            'refund' => array('*'),
            'order' => array('*'),
            'user' => array('*'),
            'aut' => array('logout'),
            'index' => array('page404'),
            'agent' => array('*')
        );
        foreach ($publicResources as $resource => $actions) {
            $acl->addResource(new Phalcon\Acl\Resource($resource), $actions);
        }

        foreach ($privateResources as $resource => $actions) {
            $acl->addResource(new Phalcon\Acl\Resource($resource), $actions);
        }

        foreach ($publicResources as $resource => $actions) {
            $acl->allow($roles['guests']->getName(), $resource, $actions);
        }

        foreach ($privateResources as $resource => $actions) {
            $acl->allow($roles['users']->getName(), $resource, $actions);
        }

        return $acl;
    });
	
	
	$di->set('cookies', function() {
		$cookies = new Phalcon\Http\Response\Cookies();
		$cookies->useEncryption(true);
		return $cookies;
	});
	
	$di->set('crypt', function() {
		$crypt = new Phalcon\Crypt();
		$crypt->setKey('%7$3mv^g3>0/!$*;');
		return $crypt;
	});
	
	
	$application = new \Phalcon\Mvc\Application($di);

	echo $application->handle()->getContent();

	
} catch(\Phalcon\Exception $e) {
    echo "PhalconException: ", $e->getMessage();
}