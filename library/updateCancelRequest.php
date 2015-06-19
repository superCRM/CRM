<?php

include_once 'library/getKeyList.php';


function updateCancelRequest($db, $id_refund, $agent_id, $final_percent, $keysCancelled)
{
    $res = array();
    $keys = getKeyList($db, $id_refund);

    $query = $db->prepare("SELECT percent FROM refund WHERE id = :id_refund");
    $query->bindParam(':id_refund', $id_refund, PDO::PARAM_INT);
    $query->execute();

    while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
        $res[] = $row;
    }

    $percent = $res[0]['percent'];
    if ($final_percent >= $percent) $final_percent = $percent;

    $query = $db->prepare("INSERT INTO agent_refund (refund_id, agent_id) VALUES (:id_refund, :agent_id)");
    $query->bindParam(':id_refund', $id_refund, PDO::PARAM_INT);
    $query->bindParam(':agent_id', $agent_id, PDO::PARAM_INT);
    $query->execute();

    $query = $db->prepare("UPDATE refund SET status = 1, final_percent= :final_percent WHERE id=:id_refund");
    $query->bindParam(':id_refund', $id_refund, PDO::PARAM_INT);
    $query->bindParam(':final_percent', $final_percent);
    $query->execute();

    //without checking <=100% in keys.percent
    for ($i = 0; $i < count($keys); $i++) {
        $query = $db->prepare("UPDATE `keys` SET status = 0, percent = percent + :final_percent WHERE key_id = :key_id");
        $query->bindParam(':key_id', $keys[$i]['key_id'], PDO::PARAM_INT);
        $query->bindParam(':final_percent', $final_percent);
        $query->execute();
    }
    var_dump($keysCancelled);
    for ($i = 0; $i < count($keysCancelled); $i++) {
        $query = $db->prepare("UPDATE `keys` SET status = 1 WHERE key_id = :key_id");
        $query->bindParam(':key_id', $keysCancelled[$i], PDO::PARAM_INT);
        $query->execute();
        echo "{$keys[$i]}";
    }
}
/**
 * Created by PhpStorm.
 * User: unevmerzhuzkiy
 * Date: 6/15/15
 * Time: 5:06 PM
 */

/**
 * @param $db PDO
 * @param $id
 * @param $status
 * @return mixed
 */
/*function updateCancelRequest($db, $id, $agent_id, $final_sum, $status)
{
    $query = $db->prepare("UPDATE refund SET status = :status, agent_id = :agent_id, final_percent= :final_sum WHERE id=:id");
    $query->bindParam(':id', $id, PDO::PARAM_INT);
    $query->bindParam(':agent_id', $agent_id, PDO::PARAM_INT);
    $query->bindParam(':final_sum', $final_sum);
    $query->bindParam(':status', $status, PDO::PARAM_INT);
    return $query->execute();
}
?>
*/