<?php
class TaobaoCallbakView extends BaseView
{
	public function index()
	{
		$connectModel = new ConnectModel ( $this->ServerName );
		$code = null;
		if (empty ( $_GET ['code'] ))
		{
			$msg = empty ( $_GET ['error_description'] ) ? null : $_GET ['error_description'];
			$errorCode = empty ( $_GET ['error'] ) ? 0 : $_GET ['error'];
			$this->responseError ( $msg, $errorCode );
		}
		$code = $_GET['code'];
		$taobaoInfo = $connectModel->getTaobaoInfo($code);
		
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
}