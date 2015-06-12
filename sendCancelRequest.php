<?php
/**
 * Created by PhpStorm.
 * User: unevmerzhuzkiy
 * Date: 6/11/15
 * Time: 8:05 PM
 */

$user = array("name" =>"alex","email"=>"alex@gmail.com");

$json = json_encode($user);
echo sendData("regInfo",$json,"10.55.33.24/dev/addUser.php");
function sendData($key_info,$info, $address){
    $url = $address;
    $fields = array(

        $key_info => $info
    );
    $fields_str = '';
    foreach($fields as $key=>$value)
    {
        $fields_str .= $key.'='.$value.'&';
    }
    $fields_str = trim($fields_str, '&');
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $fields_str);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($ch);
    curl_close($ch);
    return $response;
}
?>