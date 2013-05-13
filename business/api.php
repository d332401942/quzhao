<?php

class ApiBusiness extends BaseBusiness
{

	/**
	 * 重新设置分类缓存
	 */
	public function resetCache()
	{
		$data = new ('CategoryData');
		$data->resetCache();
	}
	
}
