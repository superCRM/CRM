<?php
/**
 * Created by PhpStorm.
 * User: nmakarenko
 * Date: 15.06.15
 * Time: 16:27
 */

function getOrderList ($db, $email) {

    $res = array();

    $query = $db->prepare("SELECT order_num, product, sum, refunded_sum from orders WHERE email_us = :email");
    $query->bindParam(':email', $email, PDO::PARAM_STR);

    $query->execute();

    while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
        $res[] = $row;
    }

    return $res;
}