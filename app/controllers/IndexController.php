<?php

use Phalcon\Mvc\Controller;

/**
 * @RoutePrefix("/")
 **/

class IndexController extends BaseController
{
	/**
	* @Get("/")
	*/
    public function indexAction()
    {
    }
	
	/**
	* @Get("page404")
	*/
	public function page404Action()
	{
		echo '404 - route not found';
	}
	
}