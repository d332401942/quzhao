<?php 

class AddMerchantsView extends BaseView
{
	public function index($parameter)
	{
		$cid = isset($parameter['cid'])?(int)$parameter['cid']:'';
		$oneModel = null;
		if($cid)
		{
			$business = M('MerchantsBusiness');	
			$oneModel = $business->getOneById($cid);
		}
		$business = M('MerchantsBusiness');
		if (!empty($_POST))
		{
			$model = M('MerchantsDataModel');
			$model->name = trim($_POST['name']);
			$model->sort = intval($_POST['sort']);
			if($_POST['id'])
			{
				$model->id = intval($_POST['id']);
				$business->update($model);
			}
			else{
				$business->add($model);
			}
			$this->redirect(APP_URL.'merchants/add');
		}
		$result = $business->getAll();
		$this->assign('model', $result);
		$this->assign('title', '商家管理');
		$this->assign('oneModel', $oneModel);
	}
}