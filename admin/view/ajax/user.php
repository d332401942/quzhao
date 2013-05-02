<?php

class UserAjaxView extends BaseAjaxView
{

    public function loginOut()
    {
        setcookie('UserInfo', '', -1,'/');
        $this->response(true);
    }
    
    /**
     * 改变前台用户的权限
     */
    public function updateRegUserPower()
    {
    	$userId = isset($_POST['userId']) ? (int)$_POST['userId'] : null;
    	$power = isset($_POST['power']) ? (int)$_POST['power'] : null;
    	if (!$userId)
    	{
    		$this->responseError('没有用户ID');
    	}
    	if (!$power)
    	{
    		$this->responseError('没有权限值');
    	}
    	$business = new UserBusiness();
    	$business->updateRegUserPower($userId, $power);
    	$this->response(true);
    }

    /**
     * 删除前台用户
     */
    public function delRegUser()
    {
    	$userId = isset($_POST['userId']) ? (int)$_POST['userId'] : null;
    	if (!$userId)
    	{
    		$this->responseError('没有用户ID');
    	}
    	$business = new UserBusiness();
    	$business->delRegUser($userId);
    	$this->response(true);
    }
}

