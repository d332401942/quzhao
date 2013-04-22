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
		
		$data->addUser($model);
    }
    
    /**
     * 通过第三方登录数据获取用户信息
     * 
     */
    public function getUserInfoByOther($openId, $userInfo, $type)
    {
    	$data = M('UserData');
    	$model = $data->getUserInfoByOther($openId, $type);
    	$nickname = null;
    	if ($type == UserDataModel::OTHER_SITE_QQ)
    	{
    		$nickname = $userInfo['nickname'];
    		$nickname = mb_convert_encoding($nickname, 'utf-8', 'gbk');
    	}
    	else if ($type == UserDataModel::OTHER_SITE_TAOBAO)
    	{
    		$nickname = $userInfo['taobao_user_nick'];
    	}
    	if (!$model)
    	{
    		//添加一个第三方注册用户
    		$model = new UserDataModel();
    		$model->regtype 	= $type;
    		$model->createtime	= time();
    		$model->password	= 0;
    		$model->ischecked	= 0;
    		$model->point		= 0;
    		$model->inviteid	= 0;
    		$model->othersite	= 0;
    		$model->status		= 1;
    		$model->nickname = $nickname;
    		$model->openid = $openId;
    		foreach ($model as $key => $val)
    		{
    			if (empty($val))
    			{
    				$model->$key = 0;
    			}
    		}
    		$this->addOtherModel($model);
    	}
    	//修改用户昵称
    	else if ($nickname && empty($model->email))
    	{
    		$data->updateNickName($model->id, $nickname);
    	}
    	return $model;
    }
    
    public function getOneById($id)
    {
        $data = M('UserData');
        return $data->getOneById;
    }
    
	/**
	 *	通过用户名和密码获取用户信息
	 */
	public function getUserInfo($email, $password)
	{
		$data = M('UserData');
		$userModel = $data->getUserInfo($email, $password);
		return $userModel;
	}
	
	public function checkuser($name)
	{
		$data 	= new UserData();
		$result = $data->checkuser($name);
		return $result;
	}
	
	public function changeData($model)
	{
		$data = new UserData();
		$data->change($model);
	}
	
	/**
	 * 添加一个其他网站登录的用户
	 * @param unknown $model
	 */
	private function addOtherModel($model)
	{
		$data = M('UserData');
		$data->add($model);
	}
}
