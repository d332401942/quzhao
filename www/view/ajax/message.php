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
				if(!empty($_POST['shareUserId']) && (int)$_POST['shareUserId'])
				{
					$business = M('MessagelettersBusiness');
					$business->add($_POST['shareUserId'],(int)$_POST['pid']);
				}
				$this->response(true);
			}
		}
	}
	public function del()
	{
		$this->mustLogin();
		if(!empty($_POST['ids']) && (int)$_POST['ids'])
		{
			$buesiness = M('MessageBusiness');
			$buesiness->deleteMessage($_POST['ids'],$this->CurrentUser->id);
			$this->response(true);
		}
		
	}
}
?>