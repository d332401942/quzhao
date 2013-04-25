<?php 

class GetreplyUserView extends BaseView
{
	
	public function index()
	{
		$business = new ReplyBusiness();
		if (!empty($this->CurrentUser->email))
		{
			return;
		}
		$models = $this->getReply($this->CurrentUser->id);
		$this->assign('models', $models);
	}
}