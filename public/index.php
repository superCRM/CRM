<?php
use CRM\Key;
use CRM\Refund;

try {

    //Register an autoloader
    $loader = new \Phalcon\Loader();
    $loader->registerDirs(array(
        '../app/controllers/',
        '../app/models/'
    ));
	
	$loader->registerNamespaces(
		array(
			'CRM' => '../app/models/'
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
    $application = new \Phalcon\Mvc\Application($di);
	
	/*$example = new Example\Example();
	var_dump($example);*/
    var_dump(Refund::getRefundList(0));
    //echo $application->handle()->getContent();

	
} catch(\Phalcon\Exception $e) {
    echo "PhalconException: ", $e->getMessage();
}