<?php
class AddUserView extends BaseView
{
	public function index()
	{
		if (empty($_POST['agreement']))
		{
			$this->responseError('没有接受用户注册协议');
		}
		$verify = $_POST['verify'];
		if ($verify != VerifyUtilLib::getVerifyCode())
		{
			$this->responseError('验证码不正确！');
		}
		
		$business = M('UserBusiness');
		$model = new UserDataModel();
		$model->email 		= trim($_POST['email']);
		$model->password 	= trim($_POST['password']);
		$model->regtype 	= UserDataModel::REG_DEFAULT;
		$model->createtime	= time();
		$model->ischecked	= 0;
		$model->point		= 0;
		$model->inviteid	= 0;
		$model->otheraccount= UserDataModel::REG_DEFAULT;
		$model->othersite	= 0;
		$model->status		= 1;
		$business->register($model);
		exit;
	}	
}
?>