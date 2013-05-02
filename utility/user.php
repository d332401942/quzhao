<?php

class UserUtility extends Feng
{
	
	/**
	 * 把登录用户信息写入cookie和缓存
	 * @param unknown $userModel
	 */
	public function setViewUser($userModel) 
	{
		setcookie(BaseView::USER_INFO_COOKIE_KEY, json_encode($userModel), 0, '/');
		$userId = $userModel->id;
		$sessionId = CommUtility::getUserSessionId();
		$business = new UserBusiness();	
		$business->setViewUserToCache($sessionId, $userId);	
	}
	
	public function loginOut()
	{
		setcookie(BaseView::USER_INFO_COOKIE_KEY, '', -1, '/');
		$business = new UserBusiness();
		$sessionId = CommUtility::getUserSessionId();
		$business->delViewUserToCache($sessionId);
	}
}