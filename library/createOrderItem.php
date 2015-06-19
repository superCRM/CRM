<?php
function createOrder($db, $email, $order_id, $keys){

    $queryToOrder = $db->prepare("INSERT INTO orders (email_us, key_num, order_id)
                                    VALUES(:email, :key_num, :order_id)");
    $queryToOrder->bindParam(':email', $email, PDO::PARAM_STR);
    $queryToOrder->bindParam(':key_num', count($keys), PDO::PARAM_INT);
    $queryToOrder->bindParam(':order_id', $order_id);

    $orderRes = $queryToOrder->execute();

    $keyRes = true;
    $order_id = $db->lastInsertId();

    foreach($keys as $key => $value){

        $queryToKeyRefund = $db->prepare("INSERT INTO keys (key_id, order_id)
                                    VALUES(:key_id, :order_id)");
        $queryToKeyRefund->bindParam(':key_id', $value);
        $queryToKeyRefund->bindParam(':order_id', $order_id, PDO::PARAM_INT);

        $keyRes = $keyRes && $orderRes->execute();
    }

    return $keyRes && $orderRes;

}