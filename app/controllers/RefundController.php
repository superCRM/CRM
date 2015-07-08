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
            $agentId = $this->request->getPost("agent_id");

            $refund = $this->session->get("refund");
            $keysRefund = $refund->keys;

            foreach($cancelKeysId as $key=>$value):
                $keysRefund[$value] = 1;
            endforeach;
            $refund->percent = $percent;
            $refund->final_percent = $percent;

            foreach($keysRefund as $key=>$value) : $keyIds[] = $key; endforeach;
            $keys = Refund::validateRefund($percent, $keyIds, $refund->email);

            if(!$keys) return; //validation failed

            foreach($cancelKeysId as $key=>$value) : $cancelKeys[] = Key::getKey($key); endforeach;

            $refund->id = Refund::createRefund($refund->email, $percent, $keys);

            $refund->updateRefund($agentId, $cancelKeys);

            $this->view->setVar("cancelKeys", $cancelKeysId);
            $this->view->setVar("percent", $percent);
            $this->view->setVar("keyIds", $keyIds);
            $this->view->setVar("keys", $keys);
        }

    }

    public function indexSendAction(){
        $this->view->disable();
        var_dump($_POST);
        var_dump($_SESSION);
        var_dump($_GET);
        if($this->session->has('agentId')){
            $agentId = $this->session->get('agentId');
        }
        else{
            return $this->response->redirect("/index/index");
        }
        if($this->request->isPost()===true){
            $keyToCancel = $this->request->getPost('keyToCancel');
            $finalPercent = $this->request->getPost('finalPercent');
            $refund = null;
            $keyToCancelObj = array();

            foreach($keyToCancel as $key=>$value){
                $refund = Refund::getRefund($key);

                foreach($value as $key=>$value){
                    $keyToCancelObj[] = Key::getKey($value);
                }
            }

            $refund->finalPercent = $finalPercent;
            $refund->updateRefund($agentId, $keyToCancelObj, 1);

            return $this->response->redirect("/refund");
        }
        else{
            return $this->response->setContent("<html><body>Refund not found.</body></html>");
        }
    }

	public function addAction()
	{
        $this->view->disable();
        echo 'asdasf';
        var_dump($_POST);
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
				$jsonRefund = $this->request->getPost("cancel_info");
				
				if(!$jsonRefund)
				{
                    $response->setContent("<html><body>Refund not found.</body></html>");
                    $response->send();
				}
				elseif($jsonRefund)
				{
					$refund = JsonSender::convertToArray($jsonRefund);
					$percent = $refund['amount'];
					$email = $refund['email'];
					$result = Refund::validateRefund($percent,$refund['key_id'],$email);
					if(!$result)
					{
                        $response->setStatusCode(422, "Fail");
                        $response->setContent("<html><body>Fail</body></html>");
                        $response->send();
					}
					else
					{
						$keys = $result;
						Refund::createRefund($email,$percent,$keys);
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

