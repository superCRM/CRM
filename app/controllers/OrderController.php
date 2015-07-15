<?php

use Phalcon\Mvc\Controller;
use CRM\Refund;
use CRM\Key;
use CRM\SecretParams;
use CRM\JsonSender;
use CRM\Order;
use CRM\User;

class OrderController extends BaseController
{


    public function indexAction($currentPage=1)
    {
        $orders = Order::getOrderList(array());

        $paginator = new \Phalcon\Paginator\Adapter\NativeArray(
            array(
                "data" => $orders,
                "limit"=> 10,
                "page" => $currentPage
            )
        );

        $page = $paginator->getPaginate();

        if($currentPage > $page->total_pages + 1 || $currentPage < 0){
            $this->response->redirect('index/page404');
        }

        $uri = '/'.$this->dispatcher->getControllerName().'/'.$this->dispatcher->getActionName().'/';

        $this->view->setVar("orders", $page->items);
        $this->view->setVar("currentPage", $currentPage);
        $this->view->setVar("size", $page->total_pages);
        $this->view->setVar('uri', $uri);
	}

    

	public function addAction()
	{
        $this->view->disable();
        //var_dump($_POST);
        if($this->request->isPost()===true)
		{
			$secretParams = SecretParams::getSecretParams('billing');

            if(!$secretParams){
				$this->response->setStatusCode(500, "Fail");
                $this->response->setContent("Secret key not set.");
                $this->response->send();
				return;
			}
			if(SecretParams::checkUrl($secretParams->getSecretKey())){
				$jsonOrder = $this->request->getPost("orders");
				
				if(!$jsonOrder)
				{
					$this->response->setStatusCode(422, "Fail");
                    $this->response->setContent("Order not found.");
                    $this->response->send();
				}
				elseif($jsonOrder)
				{
					$order = JsonSender::convertToArray($jsonOrder);
					$sum = $order['sum'];
					$orderId = $order['order_id'];
					$userId = $order['user_id'];
					$keysId = $order['keys'];
                    /*var_dump($keysId);
                    var_dump($userId);
                    var_dump($orderId);
                    var_dump($sum);*/

					$result = Order::validateOrder($orderId,$sum,$keysId,$userId);
					if(!$result)
					{
                        $this->response->setStatusCode(422, "Fail");
                        $this->response->setContent("Validation failed");
                        $this->response->send();
					}
					else
					{
						$keysId = $result;
						Order::createOrder($orderId,$sum,User::getUser($userId)->email,$keysId);
                        $this->response->setStatusCode(200, "OK");
                        $this->response->setContent("Success");
                        $this->response->send();
					}
				}
			}
			else
			{
				$this->response->setStatusCode(422, "Fail");
                $this->response->setContent("SecretParams does not match.");
                $this->response->send();
			}
		}
	}

}

