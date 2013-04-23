<?php
class MessageAjaxView extends BaseAjaxView
{
	public function add()
	{
		$this->mustLogin();
		if($_POST)
		{
			if(!empty($_POST['message']))
			{
				$business = M('MessageBusiness');
				$model = M('MessageDataModel');
				$model->userid 		= 	$this->CurrentUser->id;
				$model->pid 		=	(int)$_POST['pid'];
				$model->creattime 	=	time();
				$model->message 	=	trim($_POST['message']);
				$business->add($model);
				$this->response(true);
			}
		}
	}
}
?>