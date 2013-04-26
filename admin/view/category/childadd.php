<?php 

class ChildaddCategoryView extends BaseView
{
	public function index()
	{
		
		$business = M('Child_cateBusiness');
		if (!empty($_POST))
		{
			$model = M('Child_cateDataModel');
			$model->name = trim($_POST['name']);
			$model->brand_cate_id	= intval($_POST['cate']);
			$business->add($model);
		}
		//获取大分类
		$cateBusiness = M('Brand_cateBusiness');
		$result = $cateBusiness->getAll();
		//获取栏目
		$childModel = $business->getAllCate();
		$this->assign('childModel', $childModel);
		$this->assign('cateModel', $result);
	}
}