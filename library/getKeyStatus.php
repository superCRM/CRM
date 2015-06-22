<?php

function getKeyStatus ($db, $keys) {
    $res = array();
    /*foreach($keys as $key=>$value){
        var_dump($value['key_id']);
   }*/
    //var_dump($keys);
    foreach($keys as $key=>$value){

        $query = $db->prepare("SELECT status FROM `keys` where key_id = :key_id");
        $key_id=(int)$value['key_id'];
        $query->bindParam(':key_id', $key_id, PDO::PARAM_INT);
        $query->execute();
        $row = $query->fetch(PDO::FETCH_ASSOC);
        $res[$value['key_id']] = $row['status'];
    }

    return $res;
}