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
            if($agent) {
                if (Validation::validatePassword($password)&&$agent->getPassword() == crypt($password,'CRYPT_SHA256')) {
                    $this->session->set("login", $login);
                    $this->session->set("agentId", $agent->id);
                    return $this->response->redirect("/refund");
                }
                else{
                    $this->flashSession->error('Enter correct password...');
                    return $this->response->redirect("/");
                }
            }
            else{
                $this->flashSession->error("Agent with login '" . $login . "' not found");
                return $this->response->redirect("/");
            }
        }
    }
}