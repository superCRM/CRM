<?php
/**
 * Created by PhpStorm.
 * User: unevmerzhuzkiy
 * Date: 6/10/15
 * Time: 6:58 PM
 */

include_once "library/db.php";
include_once "library/getKey.php";


function validateLogin($login)
{
    $loginPattern = '/^[\w]{2,20}$/';
    if(!preg_match($loginPattern, $login))
    {
        return false;
    }
    else
        return true;
}

function validatePassword($password)
{
    $passwordPattern = '/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?!.*\s).{4,20}$/';
    if(preg_match($passwordPattern,$password)!=1)
    {
        return false;
    }
    else
        return true;
}

function validateEmail($email)
{
    return filter_var($email,FILTER_VALIDATE_EMAIL);
}

/**
 * @param $percent
 * @param $keys array()
 * @return bool
 */
function validateRefund($percent,$keys)
{
    if($percent>100 || $percent<0)
        return false;
    foreach($keys as $key => $keyId)
    {
        $keyItem=getKeyById(getConnect(),$keyId);
        if($keyItem===false)
        {
            unset($keys[$key]);
            continue;
        }
        if($keyItem['status']==1||($keyItem['percent']+$percent)>100)
        {
            unset($keys[$key]);
            continue;
        }
    }
    return $keys;
}