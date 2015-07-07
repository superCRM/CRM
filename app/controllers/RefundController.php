<?php

use Phalcon\Mvc\Controller;
use CRM\Refund;
use CRM\Key;

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

}