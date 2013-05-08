<?php 

class AddkeyAssociatedView extends BaseView
{
    public function index($parameter)
	{
		$id = isset($parameter['name'])?trim($parameter['name']):'';
		$model = array();
		if($id)
		{	
			$business = M('AssociatedBusiness');
			$model = $business->getName($id);
			$model = array_pop($model);
		}
		if($_POST)
		{
			$name = trim($_POST['name']);
			$business = M('AssociatedBusiness');
			$model = new AssociatedDataModel();
			$model->keyname = $name;
			if($_POST['id'])
			{
				$business->updateName($model,trim($_POST['id']));
			}else{
				$business->add($model);
			}
			$this->redirect(APP_URL.'associated/addkey');
		}
		$this->assign('title', '关键词添加');
		$this->assign('model', $model);
	}
}
