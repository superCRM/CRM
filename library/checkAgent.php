<?php
/**
 * Created by PhpStorm.
 * User: nmakarenko
 * Date: 10.06.15
 * Time: 18:08
 */
function checkAgent ($db, $login, $pass) {
    $res = array();

    $query2 = $db->prepare("SELECT password FROM agents WHERE login = :login");
    $query2->bindParam(':login', $login, PDO::PARAM_STR);

    $query2->execute();
    while ($row = $query2->fetch(PDO::FETCH_ASSOC)) {
        $res[] = $row;
    }


    if (!empty($res) && $res[0]['password'] == crypt($pass, 'CRYPT_SHA256')) {
        return $res[0]['id'];
    }

    return false;
}