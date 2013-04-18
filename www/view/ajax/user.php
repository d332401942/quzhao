<?php 

class UserAjaxView extends AjaxCoreLib
{
	
	public function checkuser()
	{	
		$name = trim($_GET['name']);
		if(empty($name)){
			$this->responseError('用户名不能为空');
		}	
		$emailRegular = '/^\w+@\w+(\.\w+){0,1}(\.\w+)$/';
		if(!preg_match($emailRegular,$_GET['name']))
		{
			$this->responseError('邮箱格式不正确');
		}
		$business = M('UserBusiness');
		$row = $business->checkuser($_GET['name']);
		if($row)
		{
			$this->responseError('用户名已被占用');	
		}
		$this->response(true);
	}
	
	public function add()
	{
		if (empty($_POST['agreement']))
		{
			$this->responseError('没有接受用户注册协议');	
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
		try
		{
			$business->register($model);
		}
		catch(BusinessExceptionLib $e)
		{
			$this->responseError($e->getMessage(), $e->getCode());
		}	
	}
	
	public function checkverify()
	{
		$verify = trim($_GET['verify']);
		if(empty($verify)){
			$this->responseError('请填写验证码');
		}	
		if ($_GET['verify'] != VerifyUtilLib::getVerifyCode())
		{
			$this->responseError('验证码错误');
		}
	}
	
}