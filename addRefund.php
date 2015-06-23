<?php
/**
 * Created by PhpStorm.
 * User: unevmerzhuzkiy
 * Date: 6/15/15
 * Time: 6:15 PM
 */

include_once 'library/db.php';
include_once 'library/createRefundItem.php';
include_once 'library/validate.php';

if(isset($_POST['cancel_info'])){

    $json = json_decode($_POST['cancel_info'],true);
    $keys = $json['key_id'];//array
    $email =$json['email'];
    $amount =$json['amount'];

    echo $email,"\n";
    echo $amount,"\n";

    $keys = validateRefund($amount,$keys);
    var_dump($keys);
    if(count($keys) > 0 && validateEmail($email))
    {
        if(createRefund(getConnect(),$email, $amount, $keys)){
            echo 'success';
        }
        else{
            echo 'fail';
        }
    }

}

