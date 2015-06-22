<?php
function createOrder($db, $email, $order_id, $sum, $keys){

    $num = count($keys);
    if($keys === false)
        return false;

    $queryToOrder = $db->prepare("INSERT INTO orders (email_us, key_num, `sum`, order_id)
                                    VALUES(:email, :key_num, :summ , :order_id)");
    $queryToOrder->bindParam(':email', $email, PDO::PARAM_STR);
    $queryToOrder->bindParam(':key_num', $num, PDO::PARAM_INT);
    $queryToOrder->bindParam(':summ', $sum);
    $queryToOrder->bindParam(':order_id', $order_id);

    $orderRes = $queryToOrder->execute();

    $keyRes = true;
    var_dump($keys);
    foreach($keys as $key => $value){
        var_dump($order_id);
        $queryToKeyRefund = $db->prepare("INSERT INTO `keys` (key_id, order_id)
                                    VALUES(:key_id, :order_id)");
        $queryToKeyRefund->bindParam(':key_id', $value);
        $queryToKeyRefund->bindParam(':order_id', $order_id, PDO::PARAM_INT);

        $keyRes = $keyRes && $queryToKeyRefund->execute();
    }

    return $keyRes && $orderRes;

}