<?php
/**
 * Created by PhpStorm.
 * User: nmakarenko
 * Date: 11.06.15
 * Time: 19:54
 */

function createRefund($db, $email, $product, $product_num, $order_num, $product_id=0){


    //checking data
echo "$product_num";
    $query = $db->prepare("SELECT * FROM users WHERE email = :email");
    $query->bindParam(':email', $email, PDO::PARAM_STR);

    $query->execute();

    while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
        $res2[] = $row;
    }
    if(empty($res2)) {  return false;} // no users with this email

    $res2 = array();
    if ($order_num == 0){
        //find and set order_num
        $query = $db->prepare("SELECT order_num FROM orders WHERE email_us = :email AND product = :product");
        $query->bindParam(':product', $product, PDO::PARAM_STR);
        $query->bindParam(':email', $email, PDO::PARAM_STR);

        $query->execute();

        while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
            $res2[] = $row;
        }
        $order_num = $res2[0]['order_num'];
    }


    $query = $db->prepare("SELECT prod_num, prod_num_refunded FROM orders WHERE email_us = :email AND order_num = :order_num AND product = :product");
    $query->bindParam(':order_num', $order_num, PDO::PARAM_INT);
    $query->bindParam(':product', $product, PDO::PARAM_STR);
    $query->bindParam(':email', $email, PDO::PARAM_STR);

    $query->execute();

    while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
        $res1[] = $row;
    }

    $diff = $res1[0]['prod_num'] - $res1[0]['prod_num_refunded'];
    echo "$product_num";
    if (empty($res1) || $diff < $product_num) return false; //no order or refund sum is too big


    //addind

        $query = $db->prepare("INSERT INTO refund (email_us, product, date, product_num, status,product_id)
			 VALUES (:email, :product, now(), :product_num, 0,:product_id)");
        $query->bindParam(':product_num', $product_num, PDO::PARAM_INT);
        $query->bindParam(':product', $product, PDO::PARAM_STR);
        $query->bindParam(':email', $email, PDO::PARAM_STR);
        $query->bindParam(':product_id',$product_id,PDO::PARAM_INT);

        $query->execute();

        $query = $db->prepare("UPDATE orders SET prod_num_refunded = prod_num_refunded + :product_num
                                WHERE email_us = :email AND product = :product AND order_num = :order_num");
        $query->bindParam(':order_num', $order_num, PDO::PARAM_INT);
        $query->bindParam(':product', $product, PDO::PARAM_STR);
        $query->bindParam(':email', $email, PDO::PARAM_STR);
        $query->bindParam(':product_num', $product_num, PDO::PARAM_INT);

        $query->execute();

    return true;

}