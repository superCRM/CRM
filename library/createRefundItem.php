<?php
/**
 * Created by PhpStorm.
 * User: nmakarenko
 * Date: 11.06.15
 * Time: 19:54
 */


function createRefund($db, $email, $product, $sum, $order_num, $agent_id){


    //checking data
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

    $res1 = array();
    $query = $db->prepare("SELECT sum, refunded_sum FROM orders WHERE email_us = :email AND order_num = :order_num AND product = :product");
    $query->bindParam(':order_num', $order_num, PDO::PARAM_INT);
    $query->bindParam(':product', $product, PDO::PARAM_STR);
    $query->bindParam(':email', $email, PDO::PARAM_STR);

    $query->execute();

    while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
        $res1[] = $row;
    }

    $diff = $res1[0]['sum'] - $res1[0]['refunded_sum'];
    if (empty($res1) || $diff < $sum) return false; //no order or refund sum is too big


    //addind


        $query = $db->prepare("INSERT INTO refund (email_us, product, date, sum, status, order_num, agent_id, final_sum)
			 VALUES (:email, :product, now(), :sum, 0, :order_num, :agent_id, :sum)");
        $query->bindParam(':order_num', $order_num, PDO::PARAM_INT);
        $query->bindParam(':sum', $sum);
        $query->bindParam(':agent_id', $agent_id, PDO::PARAM_INT);
        $query->bindParam(':product', $product, PDO::PARAM_STR);
        $query->bindParam(':email', $email, PDO::PARAM_STR);

        $query->execute();

        $query = $db->prepare("UPDATE orders SET refunded_sum = refunded_sum + :sum
                                WHERE email_us = :email AND product = :product AND order_num = :order_num");
        $query->bindParam(':order_num', $order_num, PDO::PARAM_INT);
        $query->bindParam(':product', $product, PDO::PARAM_STR);
        $query->bindParam(':email', $email, PDO::PARAM_STR);
        $query->bindParam(':sum', $sum);

        $query->execute();

    return true;

}