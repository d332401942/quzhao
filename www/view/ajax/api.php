<?php 
class ApiAjaxView extends BaseAjaxView
{
	public function resetCache()
	{
		$business = M('ApiBusiness');
		$business->resetCache();
	}
}