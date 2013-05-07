<?php

class LoveAjaxView extends BaseAjaxView
{

	public function index()
	{
		$this->mustLogin ();
		if ($_POST)
		{
			$result = array ();
			$business = M ( 'LoveBusiness' );
			if (isset ( $_POST ['loveType'] ) && $_POST ['loveType'] == 1)
			{
				$result = $business->getLove ( ( int ) $_POST ['pid'], $this->CurrentUser->id, $_POST ['loveType'] );
			}
			else
			{
				$result = $business->getLove ( ( int ) $_POST ['pid'], $this->CurrentUser->id );
			}
			
			if ($result)
			{
				$this->responseError ( '该产品已经喜欢过' );
			}
			$model = M ( 'LoveDataModel' );
			$model->home_tj_data_id = ( int ) $_POST ['pid'];
			$model->userid = $this->CurrentUser->id;
			$model->status = 0;
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
		}
	}

}