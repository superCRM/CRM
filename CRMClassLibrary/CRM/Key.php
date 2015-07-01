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


    public static  function createKey($orderId,$keyId,$status=0,$percent=0){
        $key = new Key();
        $key->orderId = $orderId;
        $key->keyId = $keyId;
        $key->status = $status;
        $key->percent = $percent;
        $key->insert(self::TABLE_NAME);
        return $key;
    }

    public static function getKey($id){
        $items=self::select(array("key_id"=>$id));
        if(count($items)>0){
            $key = $items[0];
            return $key;
        }
        else
            return false;
    }



    public function getKeyStatus($id){
        $key = $this->getKey($id);
        return array('status'=>$key::status);
    }

    public static function getKeysByRefund($refundId){
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


    public function changeKeyStatus($status){
        $this->status = $status;
        $this->update(array("key_id"=>$this->keyId));
    }

    public function decrementKeyPercent($percent){
        $this->percent -= $percent;
        $this->update(array("key_id"=>$this->keyId));
    }

    public function validate()
    {
        $keyItem = Key::getKey(getConnect(),$this->keyId);
        if($keyItem===false)
        {
            return false;
        }
        if($keyItem->status==1||(($keyItem->percent + $this->percent)>100))
        {
            return false;
        }
        return true;
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

