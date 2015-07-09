<?php
use CRM\Key;
use CRM\Refund;
use CRM\SecretParams;
use CRM\JsonSender;
use Plagins\Security;
use Phalcon\Dispatcher;

try {

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
	
	
	
	$loader->register();
	
    //Create a DI
    $di = new Phalcon\DI\FactoryDefault();

    //Setting up the view component
	
	 /*$di->set('router', function() {
        $router = new \Phalcon\Mvc\Router\Annotations(true);
        $router->removeExtraSlashes(true);
        $router->setUriSource(\Phalcon\Mvc\Router::URI_SOURCE_SERVER_REQUEST_URI);
        $router->addResource('Index', "/");
		$router->addResource('Registration',"/registration");
        $router->notFound([
                          "controller" => "index",
                           "action"  => "page404"
        ]);
        return $router;
    });*/
	
	
	
	
    $di->set('view', function(){
        $view = new \Phalcon\Mvc\View();
        $view->setViewsDir('../app/views/');
        return $view;
    });

    $di->set('flash', function(){
        $flash = new \Phalcon\Flash\Direct(array(
            'error' => 'alert alert-error',
            'success' => 'alert alert-success',
            'notice' => 'alert alert-info',
        ));
        return $flash;
    });

    $di->setShared('session', function() {
        $session = new Phalcon\Session\Adapter\Files();
        $session->start();
        return $session;
    });
    //Handle the request

    $di->set('dispatcher', function() use ($di) {

        // Получаем стандартный менеджер событий с помощью DI
        $eventsManager = $di->getShared('eventsManager');

        // Инстанцируем плагин безопасности
        $security = new Security($di);

        // Плагин безопасности слушает события, инициированные диспетчером
        $eventsManager->attach('dispatch', $security);

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
			'refund' => array('add'),
			'order' => array('add'),
            'user' => array('add')
        );

        $privateResources = array(
            'refund' => array('*'),
            'order' => array('*'),
            'user' => array('*'),
            'aut' => array('logout','page404')
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
		$crypt->setKey('%67$3mv*2BHngj*4@!6:)N-_');
		return $crypt;
	});

	$application = new \Phalcon\Mvc\Application($di);
	/*$sec1 = new SecretParams('account','CRM','password');
	$sec1->save();
	$sec1 = new SecretParams('billing','CRM','password');
	$sec1->save();*/
    //echo SecretParams::urlSigner('localhost','/order/add','CRM','password');

	/*$postArray = array
	(
		"sum"=>50,
		"order_id"=>30009,
		"user_id"=>25,
		"keys"=>array(55,87)
	);
	
	echo JsonSender::convertToJson($postArray);*/
	echo $application->handle()->getContent();

	
} catch(\Phalcon\Exception $e) {
    echo "PhalconException: ", $e->getMessage();
}