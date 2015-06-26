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

    public static function getAgent($id)
    {
        $items=Agent::select(Agent::TABLE_NAME,array("id"=>$id));
        $pack_object = $items[0];
        $agent = new Agent();
        $agent->unpack($pack_object);
        return $agent;
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

    }

    public function pack()
    {
        // TODO: Implement pack() method.
    }

    public function unpack($pack_object)
    {
        // TODO: Implement unpack() method.
    }
}
