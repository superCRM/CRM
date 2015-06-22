<?php

include_once 'library/db.php';
include_once 'library/getEmailById.php';
include_once 'library/validate.php';
include_once 'library/createOrderItem.php';

/*var_dump($_POST['orders']);

$json2 = json_decode($_POST['orders'],true);
var_dump($json2);*/

if(isset($_POST['orders'])){

    $json = json_decode($_POST['orders'],true);
    $keys = $json['keys'];//array
    $id_user =$json['user_id'];
    $sum =$json['sum'];
    $id_order =$json['order_id'];
    $email = getEmailById(getConnect(), $id_user)['email'];

    /*var_dump($keys);
    var_dump($email);*/

    if(/*validateOrder($productName,$productId,$productCount)&&*/validateEmail($email)){

        //var_dump($email);
        if(createOrder(getConnect(), $email, $id_order, $sum, $keys)){
            echo 'fail';
        }
        else{
            echo 'success';
        }
    }
}
