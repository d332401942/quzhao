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
			$this->responseError('邮箱不正确');
		}
		$business = M('UserBusiness');
		$row = $business->checkuser($_GET['name']);
		if($row)
		{
			$this->responseError('用户名已被占用');	
		}
		$this->response(true);
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