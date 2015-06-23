<?php

function createRefund($db, $email, $percent, $keys){

    $count = count($keys);
    $queryToRefund = $db->prepare("INSERT INTO refund (email_us, key_num, percent, final_percent, `data`)
                                    VALUES(:email, :key_num, :percent, :percent, NOW())");
    $queryToRefund->bindParam(':email', $email, PDO::PARAM_STR);
    $queryToRefund->bindParam(':key_num', $count, PDO::PARAM_INT);
    $queryToRefund->bindParam(':percent', $percent);

    var_dump($refRes = $queryToRefund->execute());

    $keyRefRes = true;
    $refund_id = $db->lastInsertId();

    foreach($keys as $key => $value){

        $queryToKeyRefund = $db->prepare("INSERT INTO key_refund (key_id, refund_id)
                                    VALUES(:key_id, :refund_id)");
        $queryToKeyRefund->bindParam(':key_id', $value);
        $queryToKeyRefund->bindParam(':refund_id', $refund_id, PDO::PARAM_INT);

        $keyRefRes = $keyRefRes && $queryToKeyRefund->execute();
    }

    return $keyRefRes && $refRes;

}