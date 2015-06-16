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


if(isset($_POST['key'])){

    $inf = json_decode($_POST['key'],true);
    $email = $json->email;
    $productId = $json->productId;
    $productName = $json->productName;
    $productCount = $json->productCount;
    $orderNumber = $json->orderNumber;




    if(validateEmail($email)){

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
