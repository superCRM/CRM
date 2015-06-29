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

    }

    public function getKeyStatus($id){

    }

    public function getKeysByRefund($id){

    }

    public function getKeysByOrder($id){

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

