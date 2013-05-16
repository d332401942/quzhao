<?php

class ApiBusiness extends BaseBusiness
{

	/**
	 * 重新设置分类缓存
	 */
	public function resetCache()
	{
		if (empty($_GET['key']) || $_GET['key'] != 'agjasjgfasrgakjgfbasbgfasfaJHSFDHfgasdg')
		{
			return false;
		}
		$data = new CategoryData();
		$data->resetCache();
	}
	
}
