<?php 

class UserAjaxView extends AjaxCoreLib
{
	public function checkuser()
	{	
		$name = trim($_GET['name']);
		if(empty($name)){
			$this->responseError('用户名不能为空',CodeException::USER_EMAIL_EMPTY);
		}	
		$emailRegular = CommUtility::EMAIL_PATTERN;
		if(!preg_match($emailRegular,$_GET['name']))
		{
			$this->responseError('邮箱格式不正确',CodeException::USER_EAMIL_FORMAT);
		}
		$business = M('UserBusiness');
		$row = $business->checkuser($_GET['name']);
		if($row)
		{
			$this->responseError('用户名已被占用',CodeException::USER_EMAIL_EXISTS);	
		}
		$this->response(true);
	}
	
	public function login()
	{
		$email = null;		
		$password = null;
		if (empty($_POST['email']))
		{
			$this->responseError('请输入登录邮箱');
		}
		if (empty($_POST['password']))
		{
			$this->responseError('请输入密码');
		}
		$email = strtolower(trim($_POST['email']));
		$password = $_POST['password'];
		$this->checkverify($_POST['verify']);
		$userInfo = null;
		$business = M('UserBusiness');
		$userInfo = $business->getUserInfo($email, $password);
		print_r($userInfo);
		if (!$userInfo)
		{
			$this->responseError('用户名或者密码错误');
		}
		$this->response(true);
	}
	
	public function add()
	{
		if (empty($_POST['agreement']))
		{
			$this->responseError('没有接受用户注册协议',CodeException::USER_NO_AGREEMENT);	
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
		$this->password = $model->password;
		try
		{
			$business->register($model);
		}
		catch(BusinessExceptionLib $e)
		{
			$this->responseError($e->getMessage(), $e->getCode());
		}	
		$this->response(true);
	}
	
	public function checkverify($verify)
	{
		if(empty($verify))
		{
			$this->responseError('请填写验证码');
		}	
		$code = VerifyUtilLib::getVerifyCode();
		if (!$code) 
		{
			$this->responseError('验证码已过期');
		}
		if ($verify != $code)
		{
			$this->responseError('验证码错误');
		}
		return true;
	}
	
}