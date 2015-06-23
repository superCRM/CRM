<?php

include_once 'library/db.php';
include_once 'library/createUser.php';
include_once 'library/validate.php';


if(isset($_POST['regInfo'])){

    $json = json_decode($_POST['regInfo']);

    $login =  $json->name;
    $email = $json->email;
    $id = $json->id;

    if(validateEmail($email) && validateLogin($login)){
        if(!createUser(getConnect(), $login, $email, $id)){
            echo 'fail';
        }
        else{
            echo 'success';
        }
    }
}
