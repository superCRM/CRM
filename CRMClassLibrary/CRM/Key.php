<?php
/**
 * Created by PhpStorm.
 * User: nmakarenko
 * Date: 26.06.15
 * Time: 18:48
 */
namespace CRM;

class Key extends DbTable{
	const TABLE_NAME='keys';
    public $keyId;
    public $orderId;
    public $status;
    public $percent;

    public function createKey(){

    }

    public function getKey($id){
        $items=self::select(array("key_id"=>$id));
        $key = $items[0];
        return $key;
    }

    public function getKeyStatus($id){
        $key = $this->getKey($id);
        return array('status'=>$key::status);
    }

    public function getKeysByRefund($refundId){
        $orders = array();
        $items=self::select(array("refund_id"=>$refundId, "key_refund.key_id = keys.key_id"=>null), 'and', 'key_refund');
        for ($i = 0; $i < count($items); $i++) {
            $order =  $items[$i];
            $orders[$i] = $order;
        }
        return $orders;
    }

    public function getKeysByOrder($orderId){
        $orders = array();
        $items=self::select(array("order_id"=>$orderId));
        for ($i = 0; $i < count($items); $i++) {
            $order =  $items[$i];
            $orders[$i] = $order;
        }
        return $orders;
    }

    public function changeKeyStatus($id, $status){
    }

    public function decrementKeyPercent($id, $percent){

    }
	
	public function pack()
	{
        $this->packObject['order_id']=$this->orderId;
        $this->packObject['key_id']=$this->keyId;
        $this->packObject['status']=$this->status;
        $this->packObject['percent']=$this->percent;
	}

	public function unpack($packObject)
	{
        $this->id = $packObject['id'];
        $this->orderId = $packObject['order_id'];
        $this->keyId = $packObject['key_id'];
        $this->status = $packObject['status'];
        $this->percent = $packObject['percent'];
	}
}

