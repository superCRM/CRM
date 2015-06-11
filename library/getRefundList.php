<?php
/**
 * Created by PhpStorm.
 * User: unevmerzhuzkiy
 * Date: 6/11/15
 * Time: 5:28 PM
 */

include_once 'db.php';

function getRefundList($db,$status)
{
    $res = array();
    $query = $db->prepare("SELECT * FROM refund where status=:status ORDER BY date ASC");
	$query->bindParam(':status', $status, PDO::PARAM_INT);

    $query->execute();

    while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
        $res[] = $row;
    }

    return $res;
}
?>