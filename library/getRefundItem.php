<?php
/**
 * Created by PhpStorm.
 * User: nmakarenko
 * Date: 11.06.15
 * Time: 18:07
 */

function getRefundInfo($db, $id_refund) {
    $res = array();
    $query = $db->prepare("SELECT * FROM refund where id = :id_refund");
	$query->bindParam(':id_refund', $id_refund, PDO::PARAM_INT);

    $query->execute();

    while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
        $res[] = $row;
    }

    return $res;
}