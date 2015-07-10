<?php
/**
 * Created by PhpStorm.
 * User: unevmerzhuzkiy
 * Date: 6/29/15
 * Time: 7:19 PM
 */

namespace CRM;


class JsonSender {
    const BILLING = "http://dev-billing.mvc/get-refund http://10.55.33.38:8080/get-refund";
    const BILLING_DOMAIN = '10.55.33.38:8080';
    const BILLING_PATH = '/get-refund';

    const KEY_INFO = "refund";

    public static function convertToJson($data)
    {
        return json_encode($data,true);
    }

    public static function convertToArray($jsonData)
    {
        return json_decode($jsonData, true);
    }

    public static function sendData($info, $address=self::BILLING, $key_info=self::KEY_INFO){
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

} 