<?php
/**
 * Created by PhpStorm.
 * User: unevmerzhuzkiy
 * Date: 6/26/15
 * Time: 6:33 PM
 */
//use \CRM\DbTable;
namespace CRM;
class Agent extends DbTable{
    const TABLE_NAME='agents';
    public $login;
    private  $password;
    public $email;

    public static function  createAgent($login,$password,$email)
    {
        $agent = new Agent();
        $agent->login = $login;
        $agent->password = $password;
        $agent->email = $email;
        $agent->id = $agent->insert(self::TABLE_NAME);

        return $agent;
    }

    public static function getAgent($conditional)
    {
        $agents=self::select($conditional);
        if(count($agents)==0)
            return false;
        else
        {
            $agent = $agents[0];
            return $agent;
        }
    }

    public static function getAgentById($id)
    {
        return self::getAgent(array("id"=>$id));
    }
	
	public static function validateAgent($login, $password, $email)
	{
		$status = true;
		$messages = array();
		if(!Validation::validateUsername($login))
		{
			$status = false;
			$message = "Enter correct login!";
			$messages[]=$message;
		}
        elseif(!Validation::validateEmail($email))
        {
            $status = false;
            $message = "Enter correct email!";
            $messages[]=$message;
        }
		elseif(self::getAgentByLogin($login,$email)!=false)
		{
			$status = false;
			$message = "Agent with login " . $login . " is already exists!";
			$messages[]=$message;
		}
		
		if(!Validation::validatePassword($password))
		{
			$status = false;
			$message = "Enter correct password!";
			$messages[]=$message;
		}

		return array('messages'=>$messages,'status'=>$status);
	}
	
	public static function getAgentByLogin($login,$email=null)
    {
		$conditional = array("login"=>$login);
		if($email!=null)
			$conditional['email'] = $email;
        return self::getAgent($conditional,'or');

    }

    public static function checkAgent($login,$password)
    {
        $conditional = array("login"=>$login,"password"=>crypt($password,'CRYPT_SHA256'));
        return self::getAgent($conditional);
    }

    public function __construct()
    {
    }



    public function changePassword($password)
    {
        $this->password = $password;
    }

    public function getRefunds()
    {
        return Refund::select(array("agent_refund.agent_id"=>$this->id,'refund.id=agent_refund.refund_id'=> null),'and','agent_refund');

    }

    public function pack()
    {
        $this->packObject['login']=$this->login;
		$this->packObject['password']=crypt($this->password,'CRYPT_SHA256');
		$this->packObject['email']=$this->email;
    }

    public function unpack($packObject)
    {
		$this->id = $packObject['id'];
        $this->login = $packObject['login'];
		$this->password = $packObject['password'];
		$this->email = $packObject['email'];
    }

    public function getPassword(){
        return $this->password;
    }
}
