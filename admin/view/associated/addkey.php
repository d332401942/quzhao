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
		}
		if($_POST)
		{
			$name = trim($_POST['name']);
			$business = M('AssociatedBusiness');
			$associatedModel = new AssociatedDataModel();
			$associatedModel->keyname = $name;
			if($_POST['id'])
			{
				$business->updateName($associatedModel,trim($_POST['id']));
			}
			else
			{	
				try
				{
					$business->add($associatedModel);	
				}	
				catch(BusinessExceptionLib $e)
				{
					$message = $e->getMessage();
					$this->responseError($message);
				}
			}
			$this->redirect(APP_URL.'associated/addkey');
		}
		$this->assign('title', '关键词添加');
		$this->assign('model', $model);
	}
}
