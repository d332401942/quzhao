<?php 

class LoveAjaxView extends BaseAjaxView
{
    public function index()
	{
		if($_POST)
		{
			$business = M('LoveBusiness');
			$result = $business->getLove((int)$_POST['pid'],$this->CurrentUser->id);
			if($result)
			{
				$this->responseError('该产品已经喜欢过');
			}
			$model = M('LoveDataModel');
			$model->home_tj_data_id		= (int)$_POST['pid'];
			$model->userid				= $this->CurrentUser->id;
			$model->status				= 0;
			$business->add($model);
			$business = M('HomeTjDataBusiness');
			$business->loveNum((int)$_POST['pid']);
			$this->response(true);
		}
	}
	
}