<?php

use \Phalcon\Mvc\Controller;

class BaseController extends Controller
{
	public function initialize()
	{
		$this->assets->addCss('css/bootstrap.min.css')
					->addCss('css/style.css');
		
		$this->flashSession->setCssClasses(
			array(
				 'error' => 'alert alert-danger' ,
				 'success' => 'alert alert-success' ,
				 'notice' => 'alert alert-info' ,
			)
		);
		
	}
   
}
?>