<?php
/**
 * Created by PhpStorm.
 * User: unevmerzhuzkiy
 * Date: 6/15/15
 * Time: 4:48 PM
 */

/**
 * @param $key_info 'key of post request'
 * @param $info 'array in Json'
 * @param $address 'ip address/path to file/*.php'
 * @return mixed
 */
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