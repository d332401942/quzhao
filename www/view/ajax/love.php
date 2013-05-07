<?php

class LoveAjaxView extends BaseAjaxView
{

	public function index()
	{
		$this->mustLogin ();
		if (! $_POST)
		{
			$this->responseError ( '参数错误' );
		}
		$pid = ( int ) $_POST ['pid'];
		$result = array ();
		$business = M ( 'LoveBusiness' );
		$loveType = LoveDataModel::LOVE_TYPE_HOME_TJ_DATA;
		if (isset ( $_POST ['loveType'] ) && $_POST ['loveType'] == 1)
		{
			$loveType = LoveDataModel::LOVE_TYPE_SEARCH;
		}
		$result = $business->getLove ( $pid, $this->CurrentUser->id, $loveType );
		
		$homeTjDataBusiness = M ( 'HomeTjDataBusiness' );
		if ($result)
		{
			// 删除喜欢
			$business->delLove ($result);
			$homeTjDataBusiness->loveNum ( $pid , $loveType, false);
			$this->response(-1);
		}
		else
		{
			$model = new LoveDataModel ();
			$model->home_tj_data_id = $pid;
			$model->userid = $this->CurrentUser->id;
			$model->status = 0;
<<<<<<< HEAD
			if (isset ( $_POST ['loveType'] ) && $_POST ['loveType'] == 1)
			{
				$model->loveType		= $_POST['loveType'];
				$data = M('ProductData');
				$data->loveNum((int)$_POST['pid']);
				$this->response(true);
			}
			else
			{
				$business->add ( $model );
				$business = M ( 'HomeTjDataBusiness' );
				$business->loveNum ( ( int ) $_POST ['pid'] );
				$this->response ( true );
			}
=======
			$model->loveType = $loveType;
			$business->add ( $model );
			$homeTjDataBusiness->loveNum ( $pid , $loveType);
			$this->response(1);
>>>>>>> e9410fabd8ad6a42280cd145b663ff2d10c2db1c
		}
	}

}