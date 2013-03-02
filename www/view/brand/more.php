<?php 

class MoreBrandView extends BaseView
{
	
	public function index()
	{
		$business = new HomeBrandBusiness();
		$start = $_POST['start'];
		$more = $_POST['more'];
		$models = $business->getIndexBrandData($start, $more);
		$models = $models ? $models : array();
		$this->assign('models', $models);
	}
}