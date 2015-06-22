<?php
/**
 * Created by PhpStorm.
 * User: unevmerzhuzkiy
 * Date: 6/18/15
 * Time: 8:06 PM
 */


function getKeyById($db,$id)
{
    $query = $db->prepare("SELECT * FROM `keys` where key_id=:id");
    $query->bindParam(':id', $id, PDO::PARAM_INT);

    $query->execute();

    while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
        return $row;
    }
    return false;
}

?>