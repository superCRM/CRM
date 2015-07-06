<?php

use CRM\Agent;

class AuthenticateController extends  BaseController{

    public function indexAction(){

    }


    public  function  authenticateAction(){
        if($this->request->isPost() === true){
            $login = $this->request->getPost("login","string");
            $password =  $this->request->getPost("password");
            $result = Agent::validateAgent($login,$password,$email);
            if($result['status'])
                $this->flash->success("Success");
            else
            {
                foreach($result['messages'] as $message)
                {
                    $this->flash->error($message);
                }
            }


        }
    }
}