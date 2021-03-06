<?php
/**
 * @param PDO $db
 * @param string $email
 * @param double $percent
 * @param array $keys
 * @return bool
 */

function createRefund($db, $email, $percent, $keys, $cancelKeys = array(), $status = 0){

    $count = count($keys);
    $queryToRefund = $db->prepare("INSERT INTO refund (email_us, status, key_num, percent, final_percent, `data`)
                                    VALUES(:email, :status, :key_num, :percent, :percent, NOW())");
    $queryToRefund->bindParam(':status', $status, PDO::PARAM_STR);
    $queryToRefund->bindParam(':email', $email, PDO::PARAM_STR);
    $queryToRefund->bindParam(':key_num', $count, PDO::PARAM_INT);
    $queryToRefund->bindParam(':percent', $percent);

    $refRes = $queryToRefund->execute();

    $keyRefRes = true;
    $update = true;
    $refund_id = $db->lastInsertId();

    foreach($keys as $key => $value){

        $queryToKeyRefund = $db->prepare("INSERT INTO key_refund (key_id, refund_id)
                                    VALUES(:key_id, :refund_id)");
        $queryToKeyRefund->bindParam(':key_id', $value);
        $queryToKeyRefund->bindParam(':refund_id', $refund_id, PDO::PARAM_INT);

        $keyRefRes = $keyRefRes && $queryToKeyRefund->execute();
    }

    foreach($cancelKeys as $key=>$value){
        $queryUpdate = $db->prepare("UPDATE `keys` SET status = 1
                                    WHERE key_id = :key_id");
        $queryUpdate->bindParam(':key_id', $value);
        $queryUpdate->bindParam(':percent', $percent);

        $update = $queryUpdate->execute();
    }

    if($keyRefRes && $refRes)
        return $refund_id;
    else
        return false;

}