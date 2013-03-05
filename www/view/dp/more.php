<?php 

class MoreDpView extends BaseView
{
	
	public function index()
	{
		$business = new HomeTjDataBusiness();
		$start = $_POST['start'];
		$more = $_POST['more'];
		$models = $business->getDp($start, $more);
		$models = $models ? $models : array();
		$this->assign('models', $models);
	}
}