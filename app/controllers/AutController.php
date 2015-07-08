<?php

use CRM\Agent;
use CRM\Validation;

class AutController extends  BaseController{

    public function indexAction(){

    }


    public  function  autAction(){
        //TODO change validation
        if($this->request->isPost() === true){
            $login = $this->request->getPost("login","string");
            $password =  $this->request->getPost("password");
            if(!Validation::validateUsername($login)){
                $this->flashSession->error('Enter correct login');
                return $this->response->redirect("/");
            }
            $agent = Agent::getAgentByLogin($login);
            if($agent) {
                if (Validation::validatePassword($password)&&$agent->getPassword() == crypt($password,'CRYPT_SHA256')) {
                    $this->session->set("agentId",$agent->id);
                    $this->session->set("agentId",$agent->id);
                    $this->session->set("login", $login);
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

    public function logoutAction()
    {
        $this->session->remove("agent_id");
        $this->session->remove("login");
        return $this->dispatcher->forward(
            array(
                'controller' => 'index',
                'action' => 'index'
            )
        );
    }
}