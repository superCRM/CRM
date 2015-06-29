<?php
/**
 * Created by PhpStorm.
 * User: nmakarenko
 * Date: 26.06.15
 * Time: 18:46
 */
namespace CRM;
class Order extends DbTable{
	const TABLE_NAME='orders';
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
        return User::select('users',array("email"=>$this->emailUser));
    }

    public function pack()
    {
        // TODO: Implement pack() method.
    }

    public function unpack($packObject)
    {
        // TODO: Implement unpack() method.
    }
}