<?php

class UserBusiness extends BaseBusiness
{
	/**
     * 验证用户注册信息
     * @code 返回注册状态码
     */
    public function register($model)
    {
		if(empty($model->email))
		{
			 $this->throwException('用户名不能为空',CodeException::USER_EMAIL_EMPTY);
		}
		$emailRegular = '/^\w+@\w+(\.\w+){0,1}(\.\w+)$/';
		if(preg_match($emailRegular,$model->email)==0)
		{
			$this->throwException('用户名格式不正确',CodeException::USER_EAMIL_FORMAT);
		}
		$data = new UserData();
		$result = $data->checkuser($name);
		if($result){
			$this->throwException('用户名已被占用',CodeException::USER_EMAIL_EXISTS);
		}
		if(empty($model->password))
		{
			$this->throwException('密码不能为空',CodeException::USER_PASS_EMPTY);	
		}
		$data->addUser($model);
		$this->throwException('注册成功',CodeException::USER_SUCCESS);
    }
	
	public function checkuser($name){
		$data 	= new UserData();
		$result = $data->checkuser($name);
		return $result;
	}
}
