<?php 

class HomebrandAjaxView extends BaseAjaxView
{
	
	public function delData()
	{
		$id = !empty($_POST['id']) ? (int)$_POST['id'] : null;
		$pic = !empty($_POST['pic']) ? (int)$_POST['pic'] : null;
		$business = new HomeBrandBusiness();
		$business->delData($id);
		if (file_exists($pic))
		{
			unlink($pic);
		}
		$this->response(true);
	}
}