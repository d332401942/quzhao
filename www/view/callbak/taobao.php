<?php
class TaobaoCallbakView extends BaseView
{
	
	public $connectModel;
	
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
		$code = $_GET['code'];
		$taobaoInfo = $this->getTaobaoInfo($code);
		
		if (!$taobaoInfo)
		{
			$this->responseError('获取淘宝信息失败');
		}
		if (!empty($taobaoInfo['error']))
		{
			$this->responseError($taobaoInfo);
		}
		$business = new UserBusiness ();
		$userModel = $business->getUserInfoByOther ( $taobaoInfo['taobao_user_id'], $taobaoInfo, UserDataModel::OTHER_SITE_TAOBAO );
		// 把用户信息记入cookie
		setcookie ( BaseView::USER_INFO_COOKIE_KEY, json_encode ( $userModel ), 0, '/' );
	}

	private function getTaobaoInfo($code)
	{
		$content = 'grant_type=authorization_code';
		$content .= '&client_id=' . $this->connectModel->appIdTaobao;
		$content .= '&client_secret=' . $this->connectModel->appKeyTaobao;
		$content .= '&code=' . $code;
		$content .= '&redirect_uri=' . urlencode ( $this->connectModel->redirectUriTaobao );
		$context = array (
						'http' => array (
										'method' => 'post',
										'content' => $content
						)
		);
		$stream_context = stream_context_create ( $context );
		$data = file_get_contents ( $this->connectModel->stepTaobao2 . '/token', FALSE, $stream_context );
		$info = json_decode ( $data, true );
		foreach ( $info as $key => $val )
		{
			if ($val && is_string($val))
			{
				$info [$key] = urldecode ( $val );
			}
		}
		return $info;
	}
}