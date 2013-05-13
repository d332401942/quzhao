<?php 
class ApiAjaxView extends BaseAjaxView
{
	public function reset()
	{
		$business = M('ApiBusiness');
		$business->resetCache();
	}
}