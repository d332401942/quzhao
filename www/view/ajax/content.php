 <?php
class ContentAjaxView extends BaseAjaxView
{
	 public function del()
	{
		$id = $_POST['id'];
		$pic = $_POST['pic'];
		$business = new HomeTjDataBusiness();
		$business->delById($id,(int)$_POST['userid']);
		@unlink($pic);
		$this->response(true);
	}
}	