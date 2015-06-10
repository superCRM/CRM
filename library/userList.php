<?php
/**
 * Created by PhpStorm.
 * User: nmakarenko
 * Date: 10.06.15
 * Time: 17:34
 */
function getUserList($db) {
    $res = array();
    $query = $db->prepare("SELECT * FROM users");
//	$query->bindParam(':status', $status, PDO::PARAM_INT);

    $query->execute();

    while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
        $res[] = $row;
    }

    return $res;
}