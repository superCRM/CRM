<?php
/**
 * Created by PhpStorm.
 * User: unevmerzhuzkiy
 * Date: 6/24/15
 * Time: 7:30 PM
 */

function cancelKey($db, $id_key)
{
    $query = $db->prepare("UPDATE `keys` SET status=1 where key_id=:id_key");
    $query->bindParam(':id', $id_key, PDO::PARAM_INT);
    $query->execute();
}