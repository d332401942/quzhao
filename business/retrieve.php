<?php

class RetrieveBusiness extends BaseBusiness
{
	public function getUserId($email)
	{
		$data = M('UserData');
		return $data->getUserId($email);
	}
	
	public function setMemcache($userid,$memVal)
	{
		$memcache = M('MemcacheDbLib');
		$memcache->set($userid,$memVal,0,86400);
	}
}
