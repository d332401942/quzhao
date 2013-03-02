<?php 

class HomebrandadAjaxView extends AjaxCoreLib
{
	
	public function del()
	{
		$id = $_POST['id'];
		$pic = $_POST['pic'];
		$business = new HomeBrandAdBusiness();
		$business->del($id);
		if (file_exists($pic))
		{
			unlink($pic);
		}
		$this->response(true);
	}
}