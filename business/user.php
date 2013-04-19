<?php

class UserBusiness extends BaseBusiness
{
	/**
     * 验证用户注册信息
     * @code 返回注册状态码
     */
    public function register($model)
    {
		if (empty($model->email))
		{
			 $this->throwException('用户名不能为空',CodeException::USER_EMAIL_EMPTY);
		}
		$emailRegular = CommUtility::EMAIL_PATTERN;
		if (!preg_match($emailRegular,$model->email))
		{
			$this->throwException('邮箱格式不正确',CodeException::USER_EAMIL_FORMAT);
		}
		$data = new UserData();
		$result = $data->checkuser($model->email);
		if ($result)
		{
			$this->throwException('用户名已被占用',CodeException::USER_EMAIL_EXISTS);
		}
		if (empty($model->password))
		{
			$this->throwException('密码不能为空',CodeException::USER_PASS_EMPTY);	
		}
		$model->password = md5($model->password);
		$model->email	 = strtolower($model->email); 
		$data->addUser($model);
    }
	
	public function checkuser($name)
	{
		$data 	= new UserData();
		$result = $data->checkuser($name);
		return $result;
	}
	
	public function changeData()
	{
		$data = new UserData();
		$data->update();
	}
}
