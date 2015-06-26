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

        }
        public function getUserList($id){

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
