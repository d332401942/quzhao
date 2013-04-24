<?php 

class UserAjaxView extends BaseAjaxView
{
    
	public function checkuser()
	{	
		$email = !empty($_GET['name']) ? trim($_GET['name']) : null;
		$business = M('UserBusiness');
		$business->checkuser($email);
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
		if (isset($_POST['verify']))
		{
			$this->checkverify($_POST['verify']);
		}
		$userModel = null;
		$business = M('UserBusiness');
		$userModel = $business->getUserInfo($email, $password);
		
		if (!$userModel)
		{
			$this->responseError('用户名或者密码错误');
		}
		else if ($userModel->status != BaseDataModel::IS_YES)
		{
		    $this->responseError('账号已被禁用，请联系管理员');
		}
		//把用户信息记入cookie
		setcookie(BaseView::USER_INFO_COOKIE_KEY, json_encode($userModel), 0, '/');
		$this->response(true);
	}
	
	public function loginOut()
	{
		setcookie(BaseView::USER_INFO_COOKIE_KEY, '', -1, '/');
		$this->response(true);
	}
	
	public function preSet()
	{
		$nikename = empty($_POST['nikename']) ? null : trim($_POST['nikename']);
		$email = empty($_POST['email']) ? null : trim($_POST['email']);
		$password = empty($_POST['password']) ? null : trim($_POST['password']);
		$this->mustLogin(false);
		$userModel = $this->CurrentUser;
		$userModel->nickname = $nikename;
		$userModel->email = strtolower($email);
		$userModel->password = $password;
		$business = M('UserBusiness');
		$business->preSet($userModel);
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
		foreach ($model as $key => $val)
		{
			if (empty($val))
			{
				$model->$key = 0;
			}
		}
		$this->password = $model->password;
		try
		{
			$business->register($model);
		}
		catch(BusinessExceptionLib $e)
		{
			$this->responseError($e->getMessage(), $e->getCode());
		}
		//把用户信息记入cookie
		setcookie(BaseView::USER_INFO_COOKIE_KEY, json_encode($model), 0, '/');
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