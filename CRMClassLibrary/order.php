<?php
/**
 * Created by PhpStorm.
 * User: nmakarenko
 * Date: 26.06.15
 * Time: 18:46
 */
namespace CRM;
class Order extends DbTable{
    public $orderId;
    public $emailUser;
    public $keyNum;
    public $sum;

    public function createOrder(){

    }

    public function getOrder($id){

    }

    public function getOrderList($id){

    }

    public function getKeys($id){

    }

    public function getUser(){

    }

    public function pack()
    {
        // TODO: Implement pack() method.
    }

    public function unpack($pack_object)
    {
        // TODO: Implement unpack() method.
    }
}