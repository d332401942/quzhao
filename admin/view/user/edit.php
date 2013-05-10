<?php 

class EditUserView extends BaseView
{
	
	public function index()
	{
		$this->assign('title', '会员管理');
		$id = null;
		if (isset($_GET['id']))		
		{
			$id = (int)$_GET['id'];
		}
		if (!$id)
		{
			$this->responseError('没有会员ID');
		}
		new UserDataModel();
		$business = new UserBusiness();
		$userModel = $business->getOneById($id);
		P($userModel);
		$this->assign('userModel', $userModel);
	}
}