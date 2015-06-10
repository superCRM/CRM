<?php
/**
 * Created by PhpStorm.
 * User: unevmerzhuzkiy
 * Date: 6/10/15
 * Time: 6:58 PM
 */
function validateAgentInfo($login,$password,$email)
{
    $loginPattern = '/^[a-z0-9_-]{3,20}$/';
    $passwordPattern = '/^[a-z0-9_-]{6,25}$/';

    if(preg_match($loginPattern,$login)!=1)
    {
        return false;
    }

    if(preg_match($passwordPattern,$password)!=1)
    {
        return false;
    }

    return filter_var($email,FILTER_VALIDATE_EMAIL);

}

?>