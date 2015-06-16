<?php
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
function updateCancelRequest($db,$id, $agent_id, $final_sum,$status)
{
    $query = $db->prepare("UPDATE refund SET status = :status, agent_id = :agent_id, final_sum= :final_sum WHERE id=:id");
    $query->bindParam(':id', $id, PDO::PARAM_INT);
    $query->bindParam(':agent_id', $agent_id, PDO::PARAM_INT);
    $query->bindParam(':final_sum', $final_sum);
    $query->bindParam(':status', $status, PDO::PARAM_INT);
    return $query->execute();
}
?>