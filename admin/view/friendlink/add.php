<?php

class AddFriendlinkView extends BaseView
{

	private $model;

	public function index()
	{
		$this->assign('title', '友情链接');
		$this->model = new FriendLinkDataModel();
		
		if ($_POST)
		{
			$this->add();
		}
		$this->assign('model', $this->model);
			
	}

	private function add()
	{
		$this->model->name = trim($_POST['name']);	
		$this->model->sort = (int)$_POST['sort'];
		$this->model->href = $_POST['href'];
		
		$file = new FileUploadUtilLib('logo');	
		$uploadInfo = $file->upload();
		if ($uploadInfo)
		{
			$fileName = $uploadInfo[0];
			$this->model->logo = $fileName;
		}
		$business = M('FriendLinkBusiness');
		$business->add($this->model);
		$this->success('操作成功');
	}
}
