<?php
/**
 * Created by PhpStorm.
 * User: unevmerzhuzkiy
 * Date: 6/26/15
 * Time: 6:33 PM
 */
namespace CRM;
class Agent extends DbTable{
    const TABLE_NAME='agents';
    public $login;
    private  $password;
    public $email;

    public static function  createAgent($login,$password,$email)
    {
        $agent = new agent();
        $agent->login = $login;
        $agent->password = $password;
        $agent->email = $email;
        return $agent;
    }

    public static function getAgentById($id)
    {
        $items=self::select(self::TABLE_NAME,array("id"=>$id));
        $packObject = $items[0];
        $agent = new Agent();
        $agent->unpack($packObject);
        return $agent;
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
		elseif(self::getAgentByLogin($login)!=false)
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
		
		if(!Validation::validateEmail($email))
		{
			$status = false;
			$message = "Enter correct email!";
			$messages[]=$message;
		}
		
		return array('messages'=>$messages,'status'=>$status);
	}
	
	public static function getAgentByLogin($login,$email=null)
    {
		$conditional = array("login"=>$login);
		/*TODO  create Sql builder
		if($email!=null)
			$conditional['email'] = $email;*/
        $items=self::select(self::TABLE_NAME,$conditional);
		if(count($items)==0){
			return false;
		}
		else
		{
			$packObject = $items[0];
			$agent = new Agent();
			$agent->unpack($packObject);
			return $agent;
		}
    }

    public function __construct()
    {
    }

	public static function checkAgent($login,$password)
	{
		//TODO Create validation class
		$conditional = array("login"=>$login,"password"=>crypt($password,'CRYPT_SHA256'));
		$result = self::select(self::TABLE_NAME,$conditional);
		if(count($result)==0)
			return false;
		else
		{
			$agent = new Agent();
			$agent->unpack($result[0]);
			return $agent;
		}
	}

    public function changePassword($password)
    {
        $this->password = $password;
    }

    public function getRefunds()
    {

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
}
