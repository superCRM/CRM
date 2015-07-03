<?php

use Phalcon\Mvc\Controller;

class RegistrationController extends  Controller{

    public function indexAction(){
        $this->assets->addCss('css/bootstrap.min.css')
                    ->addCss('css/style.css');
    }

    public  function  registerAction(){
        if($this->request->isPost() === true){
            $login = $this->request->getPost("login","string");
            $email = $this->request->getPost("email","email");
            $password =  $this->request->getPost("password");

            echo $login;
            echo $email;
            echo $password;
        }
    }
}