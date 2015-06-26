<?php
/**
 * Created by PhpStorm.
 * User: unevmerzhuzkiy
 * Date: 6/26/15
 * Time: 6:33 PM
 */
namespace CRM;
class Agent{
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

    public function __construct()
    {
    }

    public function getAgent()
    {

    }

    public function changePassword($password)
    {
        $this->password = $password;
    }

    public function getRefunds()
    {

    }
}
