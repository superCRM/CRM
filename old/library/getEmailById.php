<?php

function getEmailById($db, $id)
{
    $query = $db->prepare("SELECT email FROM users where id_user=:id");
    $query->bindParam(':id', $id, PDO::PARAM_INT);

    $query->execute();

    while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
        return $row;
    }
    return false;
}

