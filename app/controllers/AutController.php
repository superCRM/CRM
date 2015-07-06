<?php

use CRM\Agent;
use CRM\Validation;

class AutController extends  BaseController{

    public function indexAction(){

    }


    public  function  autAction(){
        if($this->request->isPost() === true){
            $login = $this->request->getPost("login","string");
            $password =  $this->request->getPost("password");
            $agent = Agent::getAgentByLogin($login);
            $response = new \Phalcon\Http\Response();
            if(Validation::validatePassword($password)) {
                if ($agent->getPassword() == crypt($password,'CRYPT_SHA256')) {
                    $this->session->set("login", $login);
                    $response->redirect("/refund/index");
                    $response->send();
                }
                else{
                    $response = new \Phalcon\Http\Response();
                    $response->redirect("/");
                    $response->send();
                }
            }
            else{
                echo 'Enter correct password...';
            }
        }
    }
}