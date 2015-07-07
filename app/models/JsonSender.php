<?php
/**
 * Created by PhpStorm.
 * User: unevmerzhuzkiy
 * Date: 6/29/15
 * Time: 7:19 PM
 */

namespace CRM;


class JsonSender {
    const BILLING = "http://10.55.33.38/billing_v1/get_test/test_get_refunds.php";
    const BILLING_DOMAIN = '10.55.33.38';
    const BILLING_PATH = '/billing_v1/get_test/test_get_refunds.php';

    const KEY_INFO = "refund";



    public static function convertToJson($data)
    {
        return json_encode($data,true);
    }

    public static function convertToArray($jsonData)
    {
        return json_decode($jsonData,true);
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

    public static function urlSigner($urlDomain, $urlPath, $partner, $key){
        settype($urlDomain, 'String');
        settype($urlPath, 'String');
        settype($partner, 'String');
        settype($key, 'String');
        $URL_sig = "hash";
        $URL_partner = "asid";
        $URLreturn = "";
        $URLtmp = "";
        $s = "";
        // replace " " by "+"
        if (!(strpos($urlPath, '?'))) {
            $urlPath = $urlPath.'?';
        }
        $urlPath = str_replace(" ", "+", $urlPath);
        // format URL
        if (substr($urlPath, -1) == '?') {
            $URLtmp = $urlPath . $URL_partner . "=" . $partner;
        }
        else {
            $URLtmp = $urlPath . "&" . $URL_partner . "=" . $partner;
        }
        // URL needed to create the tokken
        //$s = $urlPath . "&" . $URL_partner . "=" . $partner . $key;
        $s = $URLtmp . $key;
        $tokken = "";
        $tokken = base64_encode(pack('H*', md5($s)));
        $tokken = str_replace(array("+", "/", "="), array(".", "_", "-"), $tokken);
        $URLreturn = $urlDomain . $URLtmp . "&" . $URL_sig . "=" . $tokken;
        return $URLreturn;
    }

    public static function checkUrl($key) {
        $urlPath = stristr($_SERVER['REQUEST_URI'], '&hash', True);
        $hash = str_replace ($urlPath.'&hash=', '', $_SERVER['REQUEST_URI']);
        // replace " " by "+"
        $urlPath = str_replace(" ", "+", $urlPath);
        $urlPath = str_replace("%22", '"', $urlPath);
        // URL needed to create the tokken
        $s = $urlPath.$key;
        $tokken = "";
        $tokken = base64_encode(pack('H*', md5($s)));
        $tokken = str_replace(array("+", "/", "="), array(".", "_", "-"), $tokken);
        //var_dump($tokken);
        if ($tokken == $hash) {
            return True;
        }
        else {
            return False;
        }
    }
} 