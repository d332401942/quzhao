<?php

class QqCallbakView extends BaseCallbakView
{

	public function index()
	{
		$connectModel = new ConnectModel ( $this->ServerName );
		$access_token = empty ( $_GET ['access_token'] ) ? null : $_GET ['access_token'];
		$code = empty ( $_GET ['code'] ) ? null : $_GET ['code'];
		$url = '';
		$str = '';
		if ($code)
		{
			$url .= $connectModel->stepQQ2 . '?grant_type=authorization_code&client_id=' . $connectModel->appIdQQ;
			$url .= '&client_secret=' . $connectModel->appKeyQQ;
			$url .= '&code=' . $code . '&redirect_uri=' . urlencode ( $connectModel->redirectUriQQ );
			$str = file_get_contents ( $url );
			if (strpos ( $str, 'access_token' ) === false)
			{
				$this->responseError ( $str );
			}
			// header ( 'HTTP/1.1 301 Moved Permanently' );
			header ( 'Location: ' . $connectModel->redirectUriQQ . '?' . $str );
			exit ();
		}
		if (! $access_token)
		{
			$this->responseError ( '' );
		}
		// 拼装获取OpenAPI
		$url = $connectModel->stepQQ3 . '?access_token=' . $access_token;
		$str = file_get_contents ( $url );
		if (preg_match ( '/\((.*)\)/s', $str, $arr ))
		{
			$json = trim ( $arr [1] );
			$arr = json_decode ( $json, true );
		}
		else
		{
			$this->responseError ( '' );
		}
		$client_id = empty ( $arr ['client_id'] ) ? null : $arr ['client_id'];
		$openid = empty ( $arr ['openid'] ) ? null : $arr ['openid'];
		$getUserInfoUrl = $connectModel->stepQQ4;
		$getUserInfoUrl .= '?access_token=' . $access_token;
		$getUserInfoUrl .= '&oauth_consumer_key=' . $connectModel->appIdQQ . '&openid=' . $openid;
		$userStr = file_get_contents ( $getUserInfoUrl );
		$userInfo = json_decode ( $userStr, true );
		if ($userInfo ['ret'] != 0)
		{
			$this->responseError ( '' );
		}
		$userInfo ['openid'] = $openid;
		$business = new UserBusiness ();
		$userModel = $business->getUserInfoByOther ( $openid, $userInfo, UserDataModel::OTHER_SITE_QQ );
		$this->gotoSet($userModel);
	}

}