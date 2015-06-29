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
        $items=self::select(array("id"=>$id));
        $refund = $items[0];
        return $refund;
    }

    public function getRefundList($status){
        //$status - array
        //to create (change) function select: and => or
        $refunds = array();
        $items=self::select(array("status"=>$status));
        for ($i = 0; $i < count($items); $i++) {
            $refund = $items[$i];
            $refunds[$i] = $refund;
        }
        return $refunds;
    }

    public function updateRefund($id, $status=2){
        //change function update  - add arrays in arguments
    }

    public function getAgent($id){
        return Agent::select(array("email"=>$this->email));
    }

    public function pack()
    {
        $this->packObject['key_num']=$this->keyNum;
        $this->packObject['percent']=$this->percent;
        $this->packObject['final_percent']=$this->finalPercent;
        $this->packObject['status']=$this->status;
        $this->packObject['email_us']=$this->email;
        $this->packObject['data']=$this->data;
    }

    public function unpack($packObject)
    {
        $this->id = $packObject['id'];
        $this->keyNum = $packObject['key_num'];
        $this->percent = $packObject['percent'];
        $this->finalPercent = $packObject['final_percent'];
        $this->status = $packObject['status'];
        $this->email = $packObject['email_us'];
        $this->data = $packObject['data'];
    }
}