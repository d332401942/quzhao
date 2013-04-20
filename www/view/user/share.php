<?php
class ShareUserView extends BaseView
{
	public function index()
	{
		if($_POST){
			$business = M('ShareBusiness');
			$model = M('ShareDataModel');
			$model->userid 		= $this->CurrentUser->id;
			$model->url			= trim($_POST['url']);
			$model->title		= trim($_POST['title']);
			$model->price		= trim($_POST['price']);
			$model->image 		= trim($_POST['image']);
			$model->content 	= trim($_POST['content']);
			$model->origin 		= trim($_POST['origin']);;
			$model->createtime 	= time();
			$business->addShare($model);
			$this->redirect(APP_URL.'/user');
		}  
	}
	
}
?>