<?php 

class AddkeyAssociatedView extends BaseView
{
    public function index($parameter)
	{
		if($_POST)
		{
			$name = trim($_POST['name']);
			$business = M('AssociatedBusiness');
			$model = new AssociatedDataModel();
			$model->keyname = $name;
			$business->add($model);
		}
		$this->assign('title', '关键词添加');
	}
}
