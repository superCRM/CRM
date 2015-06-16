<?php
/**
 * Created by PhpStorm.
 * User: nmakarenko
 * Date: 15.06.15
 * Time: 19:25
 */
function getOrder($db,$order_num)
{
    $res = array();
    $query = $db->prepare("SELECT * FROM orders where order_num=:order_num");
    $query->bindParam(':order_num', $order_num, PDO::PARAM_INT);

    $query->execute();

    while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
        $res[] = $row;
    }

    return $res;
}