<?php
class QqCallbakView extends BaseView
{
	public function index()
	{
		$access_token = empty ( $_GET ['access_token'] ) ? null : $_GET ['access_token'];
		$code = empty ( $_GET ['code'] ) ? null : $_GET ['code'];
		$url = '';
		$str = '';
		if ($code)
		{
			$url .= 'https://graph.qq.com/oauth2.0/token?';
			$url .= 'grant_type=authorization_code&client_id=100384287';
			$url .= '&client_secret=b17db4b2e78d8b99ff322098a942736d';
			$url .= '&code=' . $code . '&redirect_uri=' . urlencode ( 'http://' . $this->ServerName . '/callbak/qq' );
			$str = file_get_contents ( $url );
			if (strpos ( $str, 'access_token' ) === false)
			{
				$this->responseError ( '参数错误' );
			}
			header ( 'HTTP/1.1 301 Moved Permanently' );
			header ( 'Location: ' . 'http://' . $this->ServerName . '/callbak/qq?' . $str );
			exit ();
		}
		if (! $access_token)
		{
			$this->responseError ( '' );
		}
		// 拼装获取OpenAPI
		$url = 'https://graph.qq.com/oauth2.0/me?access_token=' . $access_token;
		$str = file_get_contents ( $url );
		if (preg_match ( '/\((.*)\)/s', $str, $arr ))
		{
			$json = trim ( $arr [1] );
			$arr = json_decode ( $json, true );
			P ( $arr );
		} else
		{
			$this->responseError ( '' );
		}
		$client_id = $arr ['client_id'];
		$openid = $arr ['openid'];
		$getUserInfoUrl = 'https://graph.qq.com/user/get_user_info?';
		$getUserInfoUrl .= 'access_token=49D2D60F07633B2F20C9F49B0170CD26';
		$getUserInfoUrl .= '&oauth_consumer_key=100384287&openid=' . $openid;
		echo $str;
		exit ();
		$this->assign ( 'access_token', $access_token );
		$this->assign ( 'str', $str );
	}
}