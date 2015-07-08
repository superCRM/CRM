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

    public $keys = array();

    public function addKey($key_id){
        $this->keys[$key_id] = 0;
    }

    /**
     * @param $email
     * @param $percent
     * @param array<Key> $keys
     * @param $cancelKeys array<Key>
     * @param int $status
     */
    public static  function createRefund($email, $percent, $keys, $cancelKeys = array(), $status = 0){
        $refund = new Refund();
        $refund->keyNum = count($keys);
        $refund->percent = $percent;
        $refund->finalPercent = $percent;
        $refund->status = $status;
        $refund->email = $email;
        $refund->data = 'now()';
        $refund->id = $refund->insert(self::TABLE_NAME);

        foreach($keys as $key => $value){

            $refund->insert('key_refund', array('key_id'=>$value->keyId, 'refund_id'=>$refund->id));
        }

        foreach($cancelKeys as $value)
        {
            $value->changeKeyStatus(1);
        }
    }

    public static function  validateRefund($percent, $keysId, $email)
    {
        $keys = array();
		if(!Validation::validateEmail($email))
			return false;
        if($percent>100 || $percent<0)
            return false;
        foreach($keysId as $keyId)
        {
            $keyItem=Key::validateKey($keyId,$percent);
            if($keyItem!=false)
            {
                $keys[] = $keyItem;
            }
        }
		if(count($keys)>0)
			return $keys;
		else
			return false;
    }

    public static  function getRefund($id){
        $items=self::select(array("id"=>$id));
        $refund = $items[0];
        return $refund;
    }

    public static function getRefundList($status){
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

    public function updateRefund($id, $status=2, $keysCancelled=array()){
        $this->status = $status;
        $this->insert('agent_refund',array('refund_id'=>$this->id,'agent_id'=>$id));
        if($this->finalPercent > $this->percent)
            $this->finalPercent = $this->percent;
        $this->update(array('id'=>$this->id));
        $keys = Key::getKeysByRefund($this->id);

        foreach($keys as $key){
            $key->percent = $key->percent + $this->finalPercent;
            $key->update(array('key_id'=>$key->keyId));
        }

        if(!empty($keysCancelled)){
            foreach($keysCancelled as $key){
                $key->status = 1;
                $key->update(array('key_id'=>$key->keyId));

            }
        }
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

    public function getId(){
        return $this->id;
    }
}