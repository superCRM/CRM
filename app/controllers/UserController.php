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
        $this->view->disable();
    }

    public function addAction()
    {

    }
} 