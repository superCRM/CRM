<?php
include_once 'library/db.php';
include_once 'library/createUser.php';

if(isset($_POST['reg_info'])){
    $inf = json_decode($_POST['reg_info'],true);
    if(!createUser(getConnect(),$inf['login'], $inf['email']))
        echo 'olol';
}