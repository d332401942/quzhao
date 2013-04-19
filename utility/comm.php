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
}