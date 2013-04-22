<?php
class ReplyAjaxView extends BaseAjaxView
{
	public function add()
	{
		if($_POST)
		{
			if(!empty($_POST['content']))
			{
				//P($_POST);exit;
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
}
?>