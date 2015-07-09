<?php

use Phalcon\Mvc\Controller;
use CRM\Agent;
use CRM\Validation;

class AgentController extends BaseController{

    public function indexAction()
    {
        $agent = CRM\Agent::getAgentById($this->session->get('agentId'));
        $this->view->setVar('agent', $agent);
    }

    public function accountAction()
    {
        if($this->request->isPost() === true){
            $login = $this->request->getPost('login');
            $email = $this->request->getPost('email');
            $password = $this->request->getPost('password');
            $confirmPas = $this->request->getPost('confirmPas');
            $id = $this->session->get('agentId');

            $currentAgent = Agent::getAgentById($id);

            if(!Validation::validateUsername($login)){
                $this->flashSession->error('Login validation failed.');
                return $this->response->redirect('/agent/index');
            }
            else{
                $currentAgent->login = $login;
            }

            if(!Validation::validateEmail($email)){
                $this->flashSession->error('Email validation failed.');
                return $this->response->redirect('/agent');
            }
            else{
                $currentAgent->email = $email;
            }

            if( (!Validation::validatePassword($password)) ||
                (!Validation::validatePassword($confirmPas)) ||
                ($password != $confirmPas)){
                $this->flashSession->error('Password validation failed or password does not match.');
                return $this->response->redirect('/agent');
            }
            else{
                $currentAgent->changePassword(crypt($password,'CRYPT_SHA256'));
            }

            $currentAgent->update(array('id'=>$id));
        }
    }
}