<?php

class ClassHomebsView extends BaseView
{
	
	public function index()
	{
		if ($_POST)
		{
			$this->add();
		}
		$business = new HomeBsClassBusiness();
		$models = $business->findAll();
		
		$this->assign('title', '商家分类');
		$this->assign('models',$models);
	}
	
	private function add()
	{
		$model = new HomeBsClassDataModel();
		$model->name = trim($_POST['name']);
		$model->sort = (int)$_POST['sort'];
		$business = new HomeBsClassBusiness();
		$business->add($model);
	}
}