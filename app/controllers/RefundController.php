<?php

use Phalcon\Mvc\Controller;
use CRM\Refund;

class RefundController extends BaseController
{
    public function indexAction()
    {
        $refunds = Refund::getRefundList(0);
        $keysList = array();

        foreach($refunds as $refund){
            $id = $refund->getId();
            $keysList[$id] = \CRM\Key::getKeysByRefund($id);
        }
        $this->view->setVar("cancelRequestList", $refunds);
        $this->view->setVar("keysList", $keysList);
    }

}