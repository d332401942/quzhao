 <?php
class ContentAjaxView extends BaseAjaxView
{
	 public function del()
	{
		$id = $_POST['id'];
		$pic = $_POST['pic'];
		$business = new HomeTjDataBusiness();
		$del = false;
		$business->delById($id,$del,(int)$_POST['userid']);
		@unlink($pic);
		$this->response(true);
	}
}	