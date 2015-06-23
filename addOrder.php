<?php

include_once 'library/db.php';
include_once 'library/getEmailById.php';
include_once 'library/validate.php';
include_once 'library/createOrderItem.php';

if(isset($_POST['orders'])){

    $json = json_decode($_POST['orders'],true);
    $id_user =$json['user_id'];
    $sum =$json['sum'];
    $id_order =$json['order_id'];
    $email = getEmailById(getConnect(), $id_user)['email'];
    $keys =  validateOrder($id_order,$sum,$json['keys']);

    if(count($keys) > 0 && validateEmail($email)){

        if(createOrder(getConnect(), $email, $id_order, $sum, $keys)){
            echo 'success';
        }
        else{
            echo 'fail';
        }
    }
}
