<?php
/**
 * Created by PhpStorm.
 * User: unevmerzhuzkiy
 * Date: 7/7/15
 * Time: 8:09 PM
 */

namespace CRM;


class SecretParams extends DbTable{
    const TABLE_NAME = "secret_keys";
    public $service;
    private $partner;
    private $secretKey;

    public function __construct($service=null,$partner=null,$secretKey=null)
    {
        if($service!=null&&$partner!=null&&$secretKey!=null)
        {
            $this->service = $service;
            $this->partner = $partner;
            $this->secretKey = $secretKey;
        }

    }


    public function getPartner()
    {
        return $this->partner;
    }

    public function getSecretKey()
    {
        return $this->$secretKey;
    }

    public static function saveSecretParams($service,$partner,$secretKey)
    {
        $secretParams = getSecretParam($service);
        if($secretParams==false){
            $secretParams = new SecretParams($service,$partner,$secretKey);
            $secretParams->insert(self::TABLE_NAME);
        }
        else
        {
            $secretParams->partner = $partner;
            $secretParams->secretKey = $secretKey;
            $secretParams->update(array("id"=>$secretParams->id));
        }

    }

    public static function getSecretParams($service)
    {
        //TODO change select
        $secretParams = SecretParams::select(array("service"=>$service));
        if(count($secretParams)>0)
            return $secretParams[0];
        else
            return false;
    }

    public function pack()
    {
        // TODO: Implement pack() method.
    }

    public function unpack($packObject)
    {
        // TODO: Implement unpack() method.
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