<?php
/**
 * Created by PhpStorm.
 * User: unevmerzhuzkiy
 * Date: 6/25/15
 * Time: 8:15 PM
 */


function decrementKeyPercent($db, $id_key,$percent)
{
    $query = $db->prepare("UPDATE `keys` SET percent=percent-:percent where key_id=:id_key");
    $query->bindParam(':id', $id_key, PDO::PARAM_INT);
    $query->bindParam(':percent',$percent,PDO::PARAM_INT);
    $query->execute();
}