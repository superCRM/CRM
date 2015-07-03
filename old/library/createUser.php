<?php

function createUser($db, $login, $email, $id){

    $res = array();

    $query2 = $db->prepare("SELECT * FROM users WHERE email = :email");
    $query2->bindParam(':email', $email, PDO::PARAM_STR);

    $query2->execute();
    while ($row = $query2->fetch(PDO::FETCH_ASSOC)) {
        $res[] = $row;
    }

    if (empty($res)) {

        $query = $db->prepare("INSERT INTO users (login, email, id_user)
			 VALUES (:login, :email, :id)");
        $query->bindParam(':login', $login, PDO::PARAM_STR);
        $query->bindParam(':email', $email, PDO::PARAM_STR);
        $query->bindParam(':id', $id, PDO::PARAM_INT);

        $query->execute();

        return true;
    }
    else return false;
}