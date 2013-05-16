<?php

class ApiBusiness extends BaseBusiness
{

	/**
	 * 重新设置分类缓存
	 */
	public function resetCache()
	{
		$ip = $_SESSION['REMOTE_ADDR'];
		echo $ip;
		$data = new CategoryData();
		$data->resetCache();
	}
	
}
