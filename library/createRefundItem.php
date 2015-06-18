<?php
/**
 * @param PDO $db
 * @param String $email
 * @param Array $keys
 * @param Number $percent
 * @return bool
 */
function createRefund($db, $email, $keys, $percent){

    $refundQuery = $db->prepare("INSERT INTO refund (email_us, percent, final_percent, "date", key_num)
                            VALUES(:email, :percent, :final_percent, NOW(), :key_num)");
    $refundQuery->bindParam(':email', $email, PDO::PARAM_STR);
    $refundQuery->bindParam(':percent', $percent);
    $refundQuery->bindParam(':final_percent', $percent);
    $refundQuery->bindParam(':key_num', count($keys));
    $refRes = $refundQuery->execute();

    $refKeyRes = true;
    $id_refund = $db->lastInsertId();

    foreach ($keys as $k=>$v) {

        $refundKeyQuery = $db->prepare("INSERT INTO refund_key (id_refund, id_key)
                                      VALUES(:id_refund, :id_key)");
        $refundKeyQuery->bindParam(':id_refund', $id_refund, PDO::PARAM_INT);
        $refundKeyQuery->bindParam(':id_key', $v, PDO::PARAM_INT);
        $refKeyRes = $refKeyRes && $refundKeyQuery->execute();

    }

    return $refRes && $refKeyRes;

}