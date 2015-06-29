<?php
/**
 * Created by PhpStorm.
 * User: unevmerzhuzkiy
 * Date: 6/29/15
 * Time: 7:19 PM
 */

namespace CRM;


class JsonConverter {
    const BILLING = "http://10.55.33.38/billing_v1/get_test/test_get_refunds.php";
    const KEY_INFO = "refund";

    public static function convertToJson($data)
    {
        return json_encode($data,true);
    }

    public static function convertToArray($jsonData)
    {
        return json_decode($jsonData);
    }

    public function sendData($key_info=self::KEY_INFO,$info, $address=self::BILLING){
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