<?php

use Phalcon\Mvc\Controller;
use CRM\Refund;
use CRM\Key;
use CRM\SecretParams;
use CRM\JsonSender;

class RefundController extends BaseController
{


    public function indexAction()
    {
        $refunds = Refund::getRefundList(0);
        //$keysList = array();

        foreach($refunds as $refund){
            $id = $refund->getId();
            $refund->keys = Key::getKeysByRefund($id);
        }
        $this->view->setVar("refunds", $refunds);
        //$this->view->setVar("keysList", $keysList);
    }

    public function setAction()
    {
        $refund = new Refund();
        if($this->session->has("refund")) {
            $refund = $this->session->get("refund");
            $this->view->setVar("email", $refund->email);
        }
        if($this->request->isPost() === true) {

            $key_id = $this->request->getPost("key_id");

            if($key_id != '') $refund->addKey($key_id);
            $this->session->set("refund",$refund);

        }

        $this->view->setVar("keys", $refund ->keys);
    }

    public function delAction()
    {
        $refund = $this->session->get("refund");
        $this->view->setVar("email", $refund->email);

        if($this->request->isPost() === true) {

            $key_id = $this->request->getPost("delete");

            if($key_id != '') $refund->delKey($key_id);
            $this->session->set("refund",$refund);

        }

        $this->view->setVar("keys", $refund ->keys);

        return $this->response->redirect("refund/set/");
    }

    public function enterAction()
    {
        if($this->request->isPost() === true) {
            $currentRefund = new Refund();
            $email = $this->request->getPost("email", "string");
            $currentRefund ->email = $email;
            $this->session->set("refund",$currentRefund);



            return $this->response->redirect("refund/set/");
        }

    }

    public function sendAction()
    {
        $keyIds = array();
        $cancelKeys = array();

        if($this->session->has("refund") && $this->request->isPost() === true) {
            $cancelKeysId = $this->request->getPost("cancelKeys");
            $percent = $this->request->getPost("percent");

            $refund = $this->session->get("refund");
            $keysRefund = $refund->keys;

            foreach($cancelKeysId as $key=>$value):
                $keysRefund[$value] = 1;
            endforeach;
            $refund->percent = $percent;

            foreach($keysRefund as $key=>$value) : $keyIds[] = $key; endforeach;
            $keys = Refund::validateRefund($percent, $keyIds);

            foreach($cancelKeysId as $key=>$value) : $cancelKeys[] = Key::getKey($key); endforeach;

            $refund->createRefund($refund->email, $percent, $keys, $cancelKeys );

            $this->view->setVar("cancelKeys", $cancelKeysId);
            $this->view->setVar("percent", $percent);
            $this->view->setVar("keyIds", $keyIds);
            $this->view->setVar("keys", $keys);
        }

    }
	
	
	//я переделал через ключ: смотреть ниже 
    public function createAction() {

        if($this->request->isPost() === true){

            $json = json_decode($this->request->getPOst('cancel_info'));
            $keys = $json['key_id'];//array
            $email =$json['email'];
            $amount =$json['amount'];
            $response = new \Phalcon\Http\Response();

            $keys = \CRM\Validation::validateRefund($amount,$keys); //протестировать

            if(count($keys) > 0 && \CRM\Validation::validateEmail($email))
            {
                Refund::createRefund($email, $amount, $keys);
                $response->setStatusCode(200, "OK");
                $response->setContent("<html><body>Success</body></html>");
                $response->send();
            }
            else{
                $response->setStatusCode(422, "OK");
                $response->setContent("<html><body>Fail</body></html>");
                $response->send();
            }
        }
    }
	
	public function addAction()
	{
		if($this->request->isPost()===true)
		{
			$secretParams = SecretParams::getSecretParams('account');
			if(!$secretParams){
				echo "Fail! Key not set!";
				return;
			}

			if(SecretParams::checkUrl($secretParams->getSecretKey())){
				$jsonRefund = $this->request->getPost("cancel_info");
				
				if(!$jsonRefund)
				{
					echo "Refund not found";
				}
				elseif($jsonRefund)
				{
					$refund = JsonSender::convertToArray($jsonRefund);
					$percent = $refund['amount'];
					$email = $refund['email'];
					$result = Refund::validateRefund($percent,$refund['key_id'],$email);
					if(!$result)
					{
						echo "Validation failed";
					}
					else
					{
						$keys = $result;
						Refund::createRefund($email,$percent,$keys);
						echo "Success! Refund add to database!";
					}
				}
			}
			else
			{
				echo "Fail. Key does not match!";
			}
			
		}
	}

}

