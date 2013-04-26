<?php 

class CateaddCategoryView extends BaseView
{
	public function index()
	{
		
		if (!empty($_POST))
		{
			$business = M('Brand_cateBusiness');
			$model = M('Brand_cateDataModel');
			$model->name = trim($_POST['name']);
			$business->add($model);
		}
		$cateBusiness = M('Brand_cateBusiness');
		$result = $cateBusiness->getAll();
		$this->assign('cateModel', $result);
	}
}