<?php
/**
 * Created by PhpStorm.
 * User: nmakarenko
 * Date: 26.06.15
 * Time: 18:54
 */
namespace CRM;
class Refund extends DbTable{
	const TABLE_NAME='refund';
    public $keyNum;
    public $percent;
    public $finalPercent;
    public $status;
    public $email;
    public $data;

    public function createRefund(){

    }

    public function getRefund($id){

    }

    public function getRefundList($id){

    }

    public function updateRefund($id){

    }

    public function getAgent($id){

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