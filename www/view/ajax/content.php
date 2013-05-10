 <?php
class ContentAjaxView extends BaseAjaxView
{
	 public function del()
	{
		$id = isset($_POST['id'])?implode(',',$_POST['id']):array();
        $pic = isset($_POST['pic'])?$_POST['pic']:array();
		$business = new HomeTjDataBusiness();
		$del = false;
		$business->delById($id,$del,(int)$_POST['userid']);
		@unlink($pic);
		$this->response(true);
	}
}	