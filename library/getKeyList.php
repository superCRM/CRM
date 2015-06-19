<?php
/**
 * Created by PhpStorm.
 * User: nmakarenko
 * Date: 19.06.15
 * Time: 16:41
 */
function getKeyList ($db, $refund_id) {
    $res = array();
    $query = $db->prepare("SELECT key_id FROM key_refund where refund_id = :refund_id");
    $query->bindParam(':refund_id', $refund_id, PDO::PARAM_INT);

    $query->execute();

    while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
        $res[] = $row;
    }

    return $res;
}

