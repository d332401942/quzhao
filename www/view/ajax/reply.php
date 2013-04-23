<?php
class ReplyAjaxView extends BaseAjaxView
{
	public function add()
	{
		$this->mustLogin();
		if($_POST)
		{
			if(!empty($_POST['content']))
			{
				$business = M('ReplyBusiness');
				$model = M('ReplyDataModel');
				$model->userid 		= 	$this->CurrentUser->id;
				$model->createtime 	=	time();
				$model->messageid 	=	(int)$_POST['messageId'];
				$model->content 	=	trim($_POST['content']);
				$business->add($model);
				$this->response(true);
			}
		}
	}
	
	public function del()
	{
		$this->mustLogin();
		if(!empty($_POST['ids']) && (int)$_POST['ids'])
		{
			$buesiness = M('ReplyBusiness');
			$buesiness->deleteReply($_POST['ids'],$this->CurrentUser->id);
			$this->response(true);
		}
		
	}
}
?>