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
        $items=self::select(self::TABLE_NAME,array("key_id"=>$id));
        $key = $items[0];
        return $key;
    }

    public function getKeyStatus($id){
        $orders = array();
        $items=self::select('key_refund',array("refund_id"=>$refundId));
        for ($i = 0; $i < count($items); $i++) {
            $order =  $items[$i];
            $orders[$i] = $order;
        }
        return $orders;
    }

    public function getKeysByRefund($refundId){
        $orders = array();
        $items=self::select('key_refund',array("refund_id"=>$refundId));
        for ($i = 0; $i < count($items); $i++) {
            $order =  $items[$i];
            $orders[$i] = $order;
        }
        return $orders;
    }

    public function getKeysByOrder($orderId){
        $orders = array();
        $items=self::select('keys',array("order_id"=>$orderId));
        for ($i = 0; $i < count($items); $i++) {
            $order =  $items[$i];
            $orders[$i] = $order;
        }
        return $orders;
    }

    public function changeKeyStatus($status){
        $this->status = $status;
        $this->update(array("key_id"=>$this->keyId));
    }

    public function decrementKeyPercent($percent){
        $this->percent -= $percent;
        $this->update(array("key_id"=>$this->keyId));
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

