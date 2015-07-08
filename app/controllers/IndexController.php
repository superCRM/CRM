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
		//Setup cookies
		$uri = $this->request->getURI();
		if($uri!="/aut/logout")
		{
			$this->session->set("uri",$uri);
		}
    }
	
	/**
	* @Get("page404")
	*/
	public function page404Action()
	{
		echo '404 - route not found';
	}
	
}