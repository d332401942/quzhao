<?php

class CommUtility extends Feng
{
	
	const EMAIL_PATTERN = '/^[\w-]+@\w+(\.\w+){0,1}(\.\w+)$/';
	
	/**
	 * 得到用户的sessionkey
	 */
	public static function getUserSessionId()
	{
	    $sessionId = null;
	    if (!empty($_COOKIE['PHPSESSID']))
	    {
	        $sessionId = $_COOKIE['PHPSESSID'];
	    }
	    return $sessionId;
	}
	
	public static function randStr(){
		$string = "0123456789ABCDEFGHIJKLMNOPQRSTUVWSYZabcdefghijklmnopqrstuvwsyz";
		$salt = '';
		for($i = 0;$i<12;$i++){
			$salt .= substr($string,mt_rand(0,strlen($string)-1),1);
		}
		return $salt;
	}
}