<?php

use CRM\Agent;
use CRM\Validation;
use Plagins\Security;

class AutController extends  BaseController{

    public function indexAction(){

    }


    public  function  autAction(){
        //TODO change validation
		$this->view->disable();
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
					$security = new Security();
					$security->setCookie($agent);
                    //$this->cookies->set('remember-me',$agent->setCookie(),time()+ 15 * 86400);
                    //setcookie('remember-me',$agent->setCookie(),time()+ 15 * 86400);
					$this->session->set("agentId",$agent->id);
                    $this->session->set("login", $login);
					if($this->session->has("uri")) {
						return $this->response->redirect($this->session->get('uri'));
					}
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
        $this->session->remove("agentId");
        $this->session->remove("login");
		$this->cookies->delete('remember-me');
        return $this->response->redirect("/");
    }
}