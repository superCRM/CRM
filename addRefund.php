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

$json = json_decode($_POST['cancel'],true);


echo $json[0];
exit();
if(isset($_POST['cancel'])){

    $json = json_decode($_POST['cancel'],true);
    $email = $json['email'];
    $productId =$json['productId'];
    $productName =$json['productName'];
    $productCount =$json['productCount'];
    $orderNumber = $json['orderNumber'];


    if(/*validateRefund($productName,$productId,$productCount)&&*/validateEmail($email)){
        echo $email;
        echo $productId;
        echo $productName;
        echo $productCount;

        if(createRefundItem(getConnect(),$email, $productName, $productCount, $orderNumber, $productId)){
            echo 'fail';
        }
        else{
            echo 'success';
        }

    }

}
