<?php
class MessageAjaxView extends BaseAjaxView
{
	public function add()
	{
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
				$model->revert		=   trim($_POST['revert']);
				$business->add($model);
				$this->response(true);
			}
		}
	}
}
?>