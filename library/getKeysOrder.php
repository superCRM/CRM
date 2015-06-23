<?php
/**
 * Created by PhpStorm.
 * User: nmakarenko
 * Date: 19.06.15
 * Time: 19:22
 */
function getKeysByOrder ($db, $order_id) {
    $res = array();
    $query = $db->prepare("SELECT key_id FROM `keys` where order_id = :order_id");
    $query->bindParam(':order_id', $order_id, PDO::PARAM_INT);

    $query->execute();

    while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
        $res[] = $row;
    }

    return $res;
}