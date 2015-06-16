<?php
/**
 * Created by PhpStorm.
 * User: nmakarenko
 * Date: 16.06.15
 * Time: 18:23
 */
function getOrderList ($db, $id) {

$query = $db->prepare("UPDATE refund SET status = 1 WHERE id = :id");
$query->bindParam(':id', $id, PDO::PARAM_INT);

$query->execute();

return true;

}