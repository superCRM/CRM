<?php
/**
 * Created by PhpStorm.
 * User: nmakarenko
 * Date: 16.06.15
 * Time: 18:23
 */

/**
 * @param $db PDO
 * @param $id
 * @param int $status
 * @return bool
 */
function changeRefundStatus ($db, $id,$status=2) {

$query = $db->prepare("UPDATE refund SET status = :status WHERE id = :id");
$query->bindParam(':id', $id, PDO::PARAM_INT);
$query->bindParam(':status',$status,PDO::PARAM_INT);
return $query->execute();;

}