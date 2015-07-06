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

            if($result['status']){
                Agent::createAgent($login,$password,$email);
                $this->flashSession->success("Success! You are registered!");
                return $this->response->redirect("/");
            }
            else
            {
                foreach($result['messages'] as $message)
                {
                    $this->flashSession->error($message);
                }
                return $this->response->redirect("/registration/");
            }


        }
    }
}