<?php 

class CreatejobClientView extends BaseView
{
	
	public function index()
	{
		$this->assign('title', '生成任务');
		if (empty($_GET['page']) || !(int)$_GET['page'])
		{
			return false;
		}
		$page = (int)$_GET['page'];
		echo $page;
	}
}