<?php

use CRM\Agent;
/**
 * @RoutePrefix("/registration")
 */

class RegistrationController extends  BaseController{
   
   
   /**
   * @Get("/")
   */
    public function indexAction(){
        
    }
	
	/**
     * @Post("/register")
     */
    public  function  registerAction(){
        if($this->request->isPost() === true){
            $login = $this->request->getPost("login","string");
            $email = $this->request->getPost("email","email");
            $password =  $this->request->getPost("password");
			$result = Agent::validateAgent($login,$password,$email);
			if($result['status']) {
                $res = Agent::createAgent($login, $password, $email);
  //              $this->view->setVar("res", $res);
                if($res != false) {
                    $this->view->setVar("registered", true);
                    $this->flash->success("Success");
                }
                $this->view->setVar("registered", false);

            }
            else
			{
                $this->view->setVar("registered", false);
				foreach($result['messages'] as $message)
				{
					$this->flash->error($message);
				}
			}

			
        }
    }
}