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

    public function getOrder($orderId){
        $items=self::select(self::TABLE_NAME,array("order_id"=>$orderId));
        $order = $items[0];
        return $order;
    }

    public function getOrderList($email){
        $orders = array();
        $items=self::select(self::TABLE_NAME,array("email_us"=>$email));
        for ($i = 0; $i < count($items); $i++) {
            $order =  $items[$i];
            $orders[$i] = $order;
        }
        return $orders;
    }

    public function getKeys($id){
        return Key::select('keys',array("order_id"=>$this->orderId));
    }

    public function getUser(){
        return User::select(array("email"=>$this->emailUser));
    }

    public function pack()
    {
        $this->packObject['order_id']=$this->orderId;
        $this->packObject['email_us']=$this->emailUser;
        $this->packObject['key_num']=$this->keyNum;
        $this->packObject['sum']=$this->sum;
    }

    public function unpack($packObject)
    {
        $this->id = $packObject['id'];
        $this->orderId = $packObject['order_id'];
        $this->emailUser = $packObject['email_us'];
        $this->keyNum = $packObject['key_num'];
        $this->sum = $packObject['sum'];
    }
}