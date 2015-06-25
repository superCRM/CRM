<?php
/**
 * Created by PhpStorm.
 * User: unevmerzhuzkiy
 * Date: 6/24/15
 * Time: 7:30 PM
 */

function changeKeyStatus($db, $id_key,$status)
{
    $query = $db->prepare("UPDATE `keys` SET status=:status where key_id=:id_key");
    $query->bindParam(':id', $id_key, PDO::PARAM_INT);
    $query->bindParam(':status',$status,PDO::PARAM_INT);
    $query->execute();
}