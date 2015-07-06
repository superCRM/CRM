<?php
namespace CRM;

class Validation
{
	public static function validateEmail($email)
	{
		return filter_var($email,FILTER_VALIDATE_EMAIL);
	}
	
	public static function validatePassword($password)
	{
		$passwordPattern = '/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?!.*\s).{4,20}$/';
		if(preg_match($passwordPattern,$password)!=1)
		{
			return false;
		}
		else
			return true;
	}
	
	public static function validateUsername($username)
	{
		$loginPattern = '/^[\w]{2,20}$/';
		if(!preg_match($loginPattern, $username))
		{
			return false;
		}
		else
			return true;
	}
}
?>