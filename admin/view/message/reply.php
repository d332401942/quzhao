<?php
class ReplyMessageView extends BaseView
{
	public function index()
	{
		$result = '';
		if(!empty($_GET['msgid']) && (int)$_GET['msgid'])
		{
			$business = M('MessageBusiness');
			$result = $business->getMsgOne($_GET['msgid']);
		}
		if($_POST)
		{
			$model = M('ReplyDataModel');
			$model->userid 		= 1;
			$model->messageid 	= $result->id;
			$model->content   	= trim($_POST['content']);
			$model->createtime	= time();
			$business = M('ReplyBusiness');
			$business->add($model);
		}
		$this->assign('title','评论回复');
		$this->assign('model',$result);
	}
}
?>