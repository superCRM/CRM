<?php

use Phalcon\Mvc\Controller;
use CRM\Refund;
use CRM\Key;
use CRM\SecretParams;
use CRM\JsonSender;

class RefundController extends BaseController
{


    public function indexAction($page)
    {
        //if(!$this->session->has("agentId")) return $this->response->redirect("/");

        $refunds = Refund::getRefundList(0);

        foreach($refunds as $refund){
            $id = $refund->getId();
            $refund->keys = Key::getKeysByRefund($id);
        }

        $uri = $this->request->getURI();
        $this->session->set("uri",$uri);


        $paginator = new \Phalcon\Paginator\Adapter\NativeArray(
            array(
                "data" => $refunds,
                "limit"=> 10,
                "page" => $page
            )
        );

        $page = $paginator->getPaginate();

        $this->view->setVar("refunds", $page->items);

    }

    public function setAction()
    {
        $refund = new Refund();
        if($this->session->has("refund")) {
            $refund = $this->session->get("refund");
            $this->view->setVar("email", $refund->email);
        }
        else {
            $this->flashSession->error('Please enter e-mail.');
            return $this->response->redirect("/refund/enter");
        }
        if($this->request->isPost() === true) {

            $key_id = $this->request->getPost("key_id");

            if($key_id != '' && is_int((int)$key_id) && (int)$key_id > 0) {
                $refund->addKey($key_id);
                $this->session->set("refund", $refund);
            }

        }
        $uri = $this->request->getURI();
        $this->session->set("uri",$uri);
        $this->view->setVar("keys", $refund ->keys);
    }

    public function delAction()
    {
		$this->view->disable();
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
        $finalPercent = 0;
		$cancelKeysId = array();
		$agentId = $this->session->get("agentId");
		$refund = new Refund();
		//Is new $cancelKeysId; is exists $cancelKeysId = $keyToCancel[$refundId];
		
		if($this->request->isPost() === true){
			if($this->session->has("refund")){
			 
				$cancelKeysId = $this->request->getPost("cancelKeys");
				$finalPercent = $this->request->getPost("percent");
                if(!is_numeric($finalPercent) || (double)$finalPercent < 0 || (double)$finalPercent > 100){
                    $this->flashSession->error("Enter correct percent");
                    //TODO create variable uri in session
                    return $this->response->redirect($this->session->get('uri'));
                }
				
				$refund = $this->session->get("refund");
                $refund->percent = $finalPercent;
				$refund->id=Refund::createRefund($refund->email, $refund->percent, $refund->keys);
				
				if($refund->id === false)
				{
					$this->flashSession->error('Refund creation failed.');
					return $this->response->redirect("/refund/enter");
				}
				else
				{
					$this->flashSession->success('Refund have been added successfully.');
				}
                $this->session->remove('refund');
			}
			else
			{
				$keyToCancel = $this->request->getPost('keyToCancel');
				
				$refundId = $this->request->getPost('id_refund');
				$refund = Refund::getRefund($refundId);
				
				$finalPercent = $this->request->getPost("finalPercent$refundId");

				$refund->keys=Key::getKeysByRefund($refund->id);
				$cancelKeysId = $keyToCancel[$refundId];
			}
			
			if(!is_numeric($finalPercent) || (double)$finalPercent < 0 || (double)$finalPercent > 100){
					$this->flashSession->error("Enter correct percent");
					//TODO create variable uri in session
					return $this->response->redirect($this->session->get('uri'));
			}

            $refund->finalPercent = $finalPercent;

			$keysRefund = $refund->keys;
			foreach($keysRefund as $key)
			{
				if($key->percent+$finalPercent>100)
				{
					$refund->delKey($key->keyId);
				}
			}
			
			if(count($refund->keys)==0)
			{
				$this->flashSession->error('Refund validation failed.');
				return $this->response->redirect($this->session->get('uri'));
			}
			
			$keyToCancelObj = array();
            if($cancelKeysId!=NULL){
                foreach($cancelKeysId as $key){
                    $keyToCancelObj[] = Key::getKey($key);
                }
            }

			$refund->finalPercent = $finalPercent;
			$checkUpdate = $refund->updateRefund($agentId, $keyToCancelObj, 1);
			if($checkUpdate == false){
				$this->flashSession->error('Refund have not been updated.');
				//TODO create variable uri in session
				return $this->response->redirect($this->session->get('uri'));
			}
			
			return $refund->sendRefund();
		}
			
    }

    public function indexSendAction(){
        $this->view->disable();
        /*var_dump($_POST);
        var_dump($_SESSION);
        var_dump($_GET);*/
        
        if($this->request->isPost()===true){
            $keyToCancel = $this->request->getPost('keyToCancel');
            $refundId = $this->request->getPost('id_refund');
            $finalPercent = $this->request->getPost("finalPercent");
            if(!is_numeric($finalPercent)||($finalPercent > 100)){
                $this->flashSession->error('Enter correct percent');
                return $this->response->redirect('/refund');
            }
            $refund = Refund::getRefund($refundId);
            $keyToCancelObj = array();

            foreach($keyToCancel[$refundId] as $key){
                $keyToCancelObj[] = Key::getKey($key);
            }

            $refund->finalPercent = $finalPercent;
            $refund->updateRefund($agentId, $keyToCancelObj, 1);
            return $refund->sendRefund();

            //return $this->response->redirect("/refund");
        }
        else{
            return $this->response->setContent("<html><body>Post not found.</body></html>");
        }
    }

	public function addAction()
	{
        $this->view->disable();

        if($this->request->isPost()===true)
		{
			$secretParams = SecretParams::getSecretParams('account');

            if(!$secretParams){
                $this->response->setContent("<html><body>Secret key not set.</body></html>");
                $this->response->send();
				return;
			}
			if(SecretParams::checkUrl($secretParams->getSecretKey())){
				$jsonRefund = $this->request->getPost("cancel_info");
				
				if(!$jsonRefund)
				{
                    $this->response->setContent("<html><body>Refund not found.</body></html>");
                    $this->response->send();
				}
				elseif($jsonRefund)
				{
					$refund = JsonSender::convertToArray($jsonRefund);
					$percent = $refund['amount'];
					$email = $refund['email'];

					$result = Refund::validateRefund($percent,$refund['key_id'],$email);
					if(!$result)
					{
                        $this->response->setStatusCode(422, "Fail");
                        $this->response->setContent("<html><body>Fail</body></html>");
                        $this->response->send();
					}
					else
					{
						$keys = $result;
						Refund::createRefund($email,$percent,$keys);
                        $this->response->setStatusCode(200, "OK");
                        $this->response->setContent("<html><body>Success</body></html>");
                        $this->response->send();
					}
				}
			}
			else
			{
                $this->response->setContent("<html><body>SecretParams does not match.</body></html>");
                $this->response->send();
			}
			
		}
	}

    public function receiveResponseAction()
    {
        //TODO Change add actions
        $this->view->disable();
        if($this->request->isPost()===true)
        {
            $secretParams = SecretParams::getSecretParams('billing');

            if(!$secretParams){
                $this->response->setStatusCode(500, "Fail");
                $this->response->setContent("<html><body>Secret key not set.</body></html>");
                $this->response->send();
                return;
            }
            if(SecretParams::checkUrl($secretParams->getSecretKey())){
                $jsonResponse = $this->request->getPost("refunds");
                if(!$jsonResponse)
                {
                    $this->response->setStatusCode(422, "Fail");
                    $this->response->setContent("<html><body>Response not found.</body></html>");
                    $this->response->send();
                }
                elseif($jsonResponse)
                {
                    $response = JsonSender::convertToArray($jsonResponse);
                    $refundId = $response['id_refund'];
                    $success = $response['success'];


                    if(!is_int((int)$refundId))
                    {
                        $this->response->setStatusCode(422, "Fail");
                        $this->response->setContent("<html><body>Post[id_refund] not found</body></html>");
                        $this->response->send();
                    }
                    else
                    {
                        $refund = Refund::getRefund($refundId);

                        if($refund===false)
                        {
                            $this->response->setStatusCode(422, "Fail");
                            $this->response->setContent("<html><body>Refund not found</body></html>");
                            $this->response->send();
                            return;
                        }

                        if($success)
                        {
                            $refund->status = 2;
                            $keysId = $response['id_keys'];
                            if(count($keysId)>0)
                            {
                                foreach($keysId as $keyId)
                                {
                                    $key = Key::getKey($keyId);
                                    $key->decrementKeyPercent($refund->finalPercent);
                                }
                            }
                        }
                        else
                        {
                            $refund->status = 3;
                            foreach($refund->getKeys() as $key)
                            {
                                $key->decrementKeyPercent($refund->finalPercent);
                            }
                        }
                        $refund->update(array("id"=>$refund->id));

                        return $this->response->redirect('/refund/receiveresponse');
                        $this->response->setStatusCode(200, "OK");
                        $this->response->setContent("<html><body>Success</body></html>");
                        $this->response->send();
                    }
                }
            }
            else
            {
                $this->response->setStatusCode(422, "Fail");
                $this->response->setContent("<html><body>SecretParams does not match.</body></html>");
                $this->response->send();
            }

        }
    }

}

