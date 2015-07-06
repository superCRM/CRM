<?php
/**
 * Created by PhpStorm.
 * User: nmakarenko
 * Date: 26.06.15
 * Time: 18:35
 */
namespace CRM;
class User extends DbTable{
    const TABLE_NAME='users';
    public $login;
    public $email;
    public $idUser;

    public function createUser($login, $email, $idUser){
        $user = new User();
        $user->login = $login;
        $user->email = $email;
        $user->idUser = $idUser;

        $user->id = $user->insert(self::TABLE_NAME);
        return $user;
    }


    public static function getUser($idUser){
        $items=self::select(array("id_user"=>$idUser));
		if(count($items)>0){
			$user = $items[0];
			return $user;
		}
		else
			return false;
    }

    public function getUserList(){
        $users = array();
        $items=self::select(array());
        for ($i = 0; $i < count($items); $i++) {
            $user = $items[$i];
            $users[$i] = $user;
        }
        return $users;
    }
	
	public static function validateUser($idUser,$email,$login)
	{
		if(Validation::validateEmail($email)===false)
			return false;
		if(Validation::validateUsername($login)===false)
			return false;
		if(self::getUser($idUser)===false)
			return false;
		return true;
	}
	
    public function pack()
    {
        $this->packObject['login']=$this->login;
        $this->packObject['email']=$this->email;
        $this->packObject['id_user']=$this->idUser;
    }

    public function unpack($packObject)
    {
        $this->id = $packObject['id'];
        $this->login = $packObject['login'];
        $this->email = $packObject['email'];
        $this->idUser = $packObject['id_user'];
    }
}