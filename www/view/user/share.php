<?php
class ShareUserView extends BaseView
{
	public function index()
	{
		if($_POST){
			$business = M('ShareBusiness');
			$model = M('ShareDataModel');
			$model->uid 		= 1;
			$model->url			= trim($_POST['url']);
			$model->title		= trim($_POST['title']);
			$model->image 		= trim($_POST['image']);
			$model->content 	= trim($_POST['content']);
			$model->origin 		= trim($_POST['origin']);;
			$model->createtime 	= time();
			$business->addShare($model);
		}           
	}
	
}
?>