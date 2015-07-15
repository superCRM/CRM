<?php
/**
 * Created by PhpStorm.
 * User: unevmerzhuzkiy
 * Date: 7/9/15
 * Time: 5:17 PM
 */

use Phalcon\Mvc\Controller;
use CRM\Refund;
use CRM\Key;
use CRM\SecretParams;
use CRM\JsonSender;
use CRM\Order;
use CRM\User;
use CRM\Validation;

class UserController extends BaseController{

    public function indexAction()
    {
        $this->view->disable();
    }

    public function addAction()
    {
        $this->view->disable();
        var_dump($_POST);
        if($this->request->isPost()===true)
        {
            $secretParams = SecretParams::getSecretParams('account');
            $response = new \Phalcon\Http\Response();

            if(!$secretParams){
                $response->setContent("Secret key not set.");
                $response->send();
                return;
            }
            if(SecretParams::checkUrl($secretParams->getSecretKey())){
                $jsonUser = $this->request->getPost("regInfo");

                if(!$jsonUser)
                {
                    $response->setContent("Post with key 'regInfo' not found.");
                    $response->send();
                }
                elseif($jsonUser)
                {
                    $user = JsonSender::convertToArray($jsonUser);
                    $login = $user['name'];
                    $email = $user['email'];
                    $idUser = $user['id'];
                    $result = User::validateUser($idUser, $email, $login);
                    if(!$result)
                    {
                        $response->setStatusCode(422, "Fail");
                        $response->setContent("Validation failed");
                        $response->send();
                    }
                    else
                    {
                        User::createUser($login, $email, $idUser);
                        $response->setStatusCode(200, "OK");
                        $response->setContent("Success");
                        $response->send();
                    }
                }
            }
            else
            {
                $response->setContent("SecretParams does not match.");
                $response->send();
            }

        }
    }

    public function activationAction() {
        $this->view->disable();
        var_dump($_POST);
        if($this->request->isPost()===true)
        {
            $secretParams = SecretParams::getSecretParams('account');
            $response = new \Phalcon\Http\Response();

            if(!$secretParams){
                $response->setContent("Secret key not set.");
                $response->send();
                return;
            }
            if(SecretParams::checkUrl($secretParams->getSecretKey())){
                $jsonUser = $this->request->getPost("validation_info");

                if(!$jsonUser)
                {
                    $response->setContent("Post with key 'activationInfo' not found.");
                    $response->send();
                }
                elseif($jsonUser)
                {
                    $info = JsonSender::convertToArray($jsonUser);

                    $keyId = $info['key_id'];
                    $email = $info['user_mail'];

                    $result = (Validation::validateEmail($email));

                    if(!$result)
                    {
                        $response->setStatusCode(422, "Fail");
                        $response->setContent("Validation failed");
                        $response->send();
                    }
                    else
                    {
                        //$user = User::getUserByEmail($email);
                        $key = Key::getKey($keyId);
                        $order = Order::getOrder($key->orderId);
                        $order->emailUser = $email;
                        $order->update(array('id'=>$order->id));
                        $response->setStatusCode(200, "OK");
                        $response->setContent("Success");
                        $response->send();
                    }
                }
            }
            else
            {
                $response->setContent("SecretParams does not match.");
                $response->send();
            }

        }
    }
} 