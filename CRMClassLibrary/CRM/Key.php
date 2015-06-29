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
		// TODO: Implement pack() method.
	}

	public function unpack($packObject)
	{
		// TODO: Implement unpack() method.
	}
}

