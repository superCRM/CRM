<?php

include_once 'library/getKeyList.php';


function updateCancelRequest($db, $id_refund, $agent_id, $final_percent, $keysCancelled)
{
    $res = null;

    $query = $db->prepare("SELECT percent FROM refund WHERE id = :id_refund");
    $query->bindParam(':id_refund', $id_refund, PDO::PARAM_INT);
    $query->execute();

    while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
        $res = $row;
    }

    $percent = $res['percent'];
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
    $query = $db->prepare("UPDATE `keys`
                        left join `key_refund` on key_refund.key_id = keys.key_id
                        SET keys.percent = keys.percent + :final_percent
                        WHERE  key_refund.refund_id=:id_refund;");
    $query->bindParam(':id_refund', $id_refund, PDO::PARAM_INT);
    $query->bindParam(':final_percent', $final_percent);
    $query->execute();

    foreach ($keysCancelled as $key=>$value) {
        $query = $db->prepare("UPDATE `keys` SET status = 1 WHERE key_id = :key_id");
        $query->bindParam(':key_id', $value, PDO::PARAM_INT);
        $query->execute();
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