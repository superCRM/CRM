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
    public function createUser(){
    }
    public function getUser($id){
        $items=self::select(self::TABLE_NAME,array("id"=>$id));
        $packObject = $items[0];
        $user = new User();
        $user->unpack($packObject);
        return $user;
    }
    public function getUserList(){
        $users = array();
        $items=self::select(self::TABLE_NAME, array());
        for ($i = 0; $i < count($items); $i++) {
            $packObject = $items[$i];
            $user = new User();
            $user->unpack($packObject);
            $users[$i] = $user;
        }
        return $users;
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