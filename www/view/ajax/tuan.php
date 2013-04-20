<?php 

class TuanAjaxView extends BaseAjaxView
{
	
	public function getRegionByCiy()
	{
		if (empty($_POST['id']))
		{
			return;
		}
		$business = new NetTuanBusiness();
		$cityRegionModels = $business->getCityRegion($_POST['id']);
		$this->response($cityRegionModels);
	}
}