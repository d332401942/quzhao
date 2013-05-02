<?php 

class AddMerchantsView extends BaseView
{
	public function index()
	{
		$business = M('MerchantsBusiness');
		if (!empty($_POST))
		{
			$model = M('MerchantsDataModel');
			$model->name = trim($_POST['name']);
			$business->add($model);
		}
		$result = $business->getAll();
		$this->assign('model', $result);
		$this->assign('title', '商家管理');
	}
}