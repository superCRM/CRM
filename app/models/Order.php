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

    public static function createOrder($orderId,$sum,$emailUser,$keys){
        $order = new Order();
        $order->orderId = $orderId;
        $order->sum = $sum;
        $order->emailUser = $emailUser;
        $order->keyNum = count($keys);

        foreach($keys as $keyId)
        {
            Key::createKey($orderId,$keyId);
        }
        $order->id = $order->insert(self::TABLE_NAME);
        return $order;
    }


    public static  function getOrder($orderId){
        $items=self::select(array("order_id"=>$orderId));
        if(count($items)==0)
            return false;
        else{
            $order = $items[0];
            return $order;
        }
    }

    public static function getOrderListByEmail($email){
        return self::getOrderList(array("email_us"=>$email));;
    }
	
	public static function getOrderList($conditional,$connector='and')
	{
		$orders = array();
        $items=self::select($conditional,$connector);
        for ($i = 0; $i < count($items); $i++) {
            $order =  $items[$i];
            $orders[$i] = $order;
        }
        return $orders;
	}

    public static function validateOrder($orderId,$sum,$keysId,$userId)
    {
		
        if(count($keysId)==0)
            return false;
		
        if($sum<0)
        {
            return false;
        }
		
		if(User::getUser($userId)==false)
			return false;
        
		if(self::getOrder($orderId)!=false)
        {
            return false;
        }
        
		foreach($keysId as $key=>$keyId)
        {
            $item = Key::getKey($keyId);
            if($item!=false)
                unset($keysId[$key]);
        }
        
		return $keysId;
    }

    public function getKeys(){
        return Key::select(array("order_id"=>$this->orderId));
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