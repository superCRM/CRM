<?php

include_once 'library/db.php';
include_once 'library/createRefundItem.php';
include_once 'library/validate.php';

var_dump($_POST['orders']);

/*$json2 = json_decode($_POST['cancel_info'],true);
var_dump($json2);*/
/*
if(isset($_POST['orders'])){

    $json = json_decode($_POST['cancel_info'],true);
    $keys = $json['key_id'];//array
    $email =$json['email'];
    $amount =$json['amount'];
    echo $email,"\n";
    echo $amount,"\n";
    var_dump($keys);
    if(validateRefund($productName,$productId,$productCount)&&validateEmail($email)){

        if(createRefundItem(getConnect(),$email, $productName, $productCount, $orderNumber, $productId)){
            echo 'fail';
        }
        else{
            echo 'success';
        }
    }
}*/
