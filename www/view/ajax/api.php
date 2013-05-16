<?php 
class ApiAjaxView extends BaseAjaxView
{
	public function resetCache()
	{
		$business = new ApiBusiness();
		$business->resetCache();
	}
}