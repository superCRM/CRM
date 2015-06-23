<?php
function getPercent ($db, $refund_id) {

    $query = $db->prepare("SELECT final_percent FROM `refund` where id = :refund_id");
    $query->bindParam(':refund_id', $refund_id, PDO::PARAM_INT);

    $query->execute();

    $row = $query->fetch(PDO::FETCH_ASSOC);

    return $row['final_percent'];
}
