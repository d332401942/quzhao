<?php 

class IndexTjclassView extends BaseView
{
	
	public function index()
	{
		$this->assign('title','推荐类别');
		if (!empty($_POST))	
		{
			$this->addTjClass();
		}
		$business = new HomeTjClassBusiness();
		$rootClassModels = $business->getRootClass();
		
		$allModels = $business->findAll();
		$this->assign('allModels',$allModels);
		$this->assign('rootClassModels',$rootClassModels);
	}
	
	private function addTjClass()
	{
		$model = new HomeTjClassDataModel();
		$model->pid = $_POST['pid'];
		$model->name = $_POST['name'];
		$model->sort = $_POST['sort'];
		$model->isuse = HomeTjClassDataModel::IS_USE_TYPE_YES;
		$business = new HomeTjClassBusiness();
		$business->add($model);
	}
	/**
	 * 删除分类
	**/
	public function delCate($parameters){
		//$business = new HomeTjClassBusiness();
		//$business->delCate($id);
		P($_POST);
	}
}