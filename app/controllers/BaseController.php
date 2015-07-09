<?php

use \Phalcon\Mvc\Controller;

class BaseController extends Controller
{
	public function initialize()
	{
		$this->assets->addCss('css/bootstrap.min.css')
					->addCss('css/style.css');

        $this->assets->addJs('js/bootstrap.js')
            ->addCss('js/jquery-1.11.3.min.js');
		
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