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

class UserController extends BaseController{

    public function indexAction()
    {

    }

    public function addAction()
    {
        if($this->request->isPost()===true)
        {
            $secretParams = SecretParams::getSecretParams('account');
            $response = new \Phalcon\Http\Response();

            if(!$secretParams){
                $response->setContent("<html><body>Secret key not set.</body></html>");
                $response->send();
                return;
            }
            if(SecretParams::checkUrl($secretParams->getSecretKey())){
                $jsonUser = $this->request->getPost("regInfo");

                if(!$jsonUser)
                {
                    $response->setContent("<html><body>Post with key 'regInfo' not found.</body></html>");
                    $response->send();
                }
                elseif($jsonUser)
                {
                    $user = JsonSender::convertToArray($jsonUser);
                    $login = $user['name'];
                    $email = $user['email'];
                    $idUser = $user['userId']
                    $result = Refund::validateUser($idUser, $email, $login);
                    if(!$result)
                    {
                        $response->setStatusCode(422, "Fail");
                        $response->setContent("<html><body>Validation failed</body></html>");
                        $response->send();
                    }
                    else
                    {
                        User::createUser($login, $email, $idUser);
                        $response->setStatusCode(200, "OK");
                        $response->setContent("<html><body>Success</body></html>");
                        $response->send();
                    }
                }
            }
            else
            {
                $response->setContent("<html><body>SecretParams does not match.</body></html>");
                $response->send();
            }

        }
    }
} 