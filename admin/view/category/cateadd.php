<?php 

class CateaddCategoryView extends BaseView
{
	public function index($parameter)
	{
		$cid = isset($parameter['cid'])?(int)$parameter['cid']:'';
		$oneModel = null;
		if($cid)
		{
			$business = M('Brand_cateBusiness');	
			$oneModel = $business->getOneById($cid);
		}
		if (!empty($_POST))
		{
			$business = M('Brand_cateBusiness');
			$model = M('Brand_cateDataModel');
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
				$this->redirect(APP_URL.'category/cateadd');
		}
		$cateBusiness = M('Brand_cateBusiness');
		$result = $cateBusiness->getAll();
		$this->assign('oneModel', $oneModel);
		$this->assign('cateModel', $result);
		$this->assign('title', '分类管理');
	}
}