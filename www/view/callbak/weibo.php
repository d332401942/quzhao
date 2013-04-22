<?php

class WeiboCallbakView extends BaseCallbakView
{

	private $connectModel;

	public function index()
	{
		$this->connectModel = new ConnectModel ( $this->ServerName );
		$code = null;
		if (empty ( $_GET ['code'] ))
		{
			$msg = empty ( $_GET ['error_description'] ) ? null : $_GET ['error_description'];
			$errorCode = empty ( $_GET ['error'] ) ? 0 : $_GET ['error'];
			$this->closeWindow ();
		}
		$code = $_GET ['code'];
		$weiboInfo = $this->getWeiboInfo ( $code );
		$business = new UserBusiness ();
		$userModel = $business->getUserInfoByOther ( $weiboInfo['id'], $weiboInfo, UserDataModel::OTHER_SITE_WEIBO );
		$this->gotoSet($userModel);
	}

	private function getWeiboInfo($code)
	{
		$content = 'grant_type=authorization_code';
		$content .= '&client_id=' . $this->connectModel->appIdWeibo;
		$content .= '&client_secret=' . $this->connectModel->appKeyWeibo;
		$content .= '&code=' . $code;
		$content .= '&redirect_uri=' . urlencode ( $this->connectModel->redirectUriWeibo );
		$context = array (
						'http' => array (
										'method' => 'post',
										'content' => $content 
						) 
		);
		$stream_context = stream_context_create ( $context );
		$data = file_get_contents ( $this->connectModel->stepWeibo2 . '/oauth2/access_token', FALSE, $stream_context );
		$info = json_decode ( $data, true );
		foreach ( $info as $key => $val )
		{
			$info [$key] = urldecode ( $val );
		}
		
		if (! empty ( $info ['error'] ))
		{
			$this->responseError ( $data );
		}
		
		// 获取授权信息
		$userInfo = $this->getUserInfo ( $info );
		return $userInfo;
	}

	private function getUserInfo($info)
	{
		$url = $this->connectModel->stepWeibo2 .'/2/users/show.json';
		$url .= '?uid='.$info['uid'];
		$url .= '&access_token=' . $info['access_token'];
		$data = file_get_contents ( $url);
		$info = json_decode ( $data, true );
		foreach ( $info as $key => $val )
		{
			if ($val && is_string($val))
			{
				$info [$key] = urldecode ( $val );
			}
		}
		
		if (! empty ( $info ['error'] ))
		{
			$this->responseError ( $data );
		}
		
		return $info;
	}

}