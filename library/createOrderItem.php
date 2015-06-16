<?php
/**
 * Created by PhpStorm.
 * User: nmakarenko
 * Date: 12.06.15
 * Time: 17:15
 */

function createOrder($db, $email, $product, $sum, $order_num){

    //checking data

    $query = $db->prepare("SELECT * FROM users WHERE email = :email");
    $query->bindParam(':email', $email, PDO::PARAM_STR);

    $query->execute();

    while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
        $res2[] = $row;
    }
    if(empty($res2)) return 0; // no users with this email


    //addind

    $query = $db->prepare("INSERT INTO orders (order_num, product, sum, refunded_sum, email_us)
			 VALUES (:order_num, :product, :sum, 0, :email)");
    $query->bindParam(':order_num', $order_num, PDO::PARAM_INT);
    $query->bindParam(':sum', $sum);
    $query->bindParam(':product', $product, PDO::PARAM_STR);
    $query->bindParam(':email', $email, PDO::PARAM_STR);

    $query->execute();


    return 1;

}