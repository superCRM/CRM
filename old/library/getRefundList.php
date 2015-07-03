<?php
/**
 * Created by PhpStorm.
 * User: unevmerzhuzkiy
 * Date: 6/11/15
 * Time: 5:28 PM
 */

include_once 'db.php';

function getRefundList($db, $status)
{
    $res = array();
    $string_query = "SELECT * FROM refund where ";
    foreach($status as $value)
    {
        $string_query .= ' status = ' . $value . ' or';
    }

    $string_query = trim($string_query, 'or');
    $string_query .=  " ORDER BY data ASC limit 15";
    $query = $db->prepare($string_query);

    $query->execute();

    while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
        $res[] = $row;
    }

    return $res;
}