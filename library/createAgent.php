<?php
/**
 * Created by PhpStorm.
 * User: nmakarenko
 * Date: 10.06.15
 * Time: 18:01
 */
/**
 * @param PDO $db
 * @param string $login
 * @param string $password
 * @param string $email
 * @return bool|int
 */
function createAgent($db, $login, $password, $email){

    var_dump(validateLogin($login));
    var_dump(validateEmail($email));
    var_dump(validatePassword($password));

    if(validateLogin($login)===false)
        return -1;

    if(validateEmail($email)===false)
    {
        return -1;
    }

    if(validatePassword($password)===false)
    {
        return -1;
    }

    $res = array();

    $query2 = $db->prepare("SELECT * FROM agents WHERE login = :login");
    $query2->bindParam(':login', $login, PDO::PARAM_STR);

    $query2->execute();
    while ($row = $query2->fetch(PDO::FETCH_ASSOC)) {
        $res[] = $row;
    }
    //var_dump($res);
    $hash_pass = crypt($password, 'CRYPT_SHA256');
    if (empty($res)) {

        $query = $db->prepare("INSERT INTO agents (login, password, email)
			 VALUES (:login, :hash_pass, :email)");
        $query->bindParam(':login', $login, PDO::PARAM_STR);
        $query->bindParam(':hash_pass', $hash_pass, PDO::PARAM_STR);
        $query->bindParam(':email', $email, PDO::PARAM_STR);

        $query->execute();

 //       echo "Last modified id: ";
 //       print($db->lastInsertId());
  //      echo "\n";

        return true;
    }
    else
        return -2;
}