<?php

class ContentAjaxView extends BaseAjaxView
{

	public function changeState()
	{
		$ids = array();
		if (! empty($_POST ['ids']))
		{
			$ids = $_POST ['ids'];
		}
		$state = ( int ) $_POST ['state'];
		$business = new HomeTjDataBusiness();
		$business->changeState($ids, $state);
		$this->response(true);
	}
    
    public function del()
    {
        $id = $_POST['id'];
        $pic = $_POST['pic'];
		$del = isset($_POST['del'])?(int)$_POST['del']:false;
        $business = new HomeTjDataBusiness();
		$business->delById($id,$del);
		@unlink($pic);
        $this->response(true);
    }
    
    public function clearSort()
    {
        $ids = $_POST['ids'];
        $business = new HomeTjDataBusiness();
        $business->clearSort($ids);
        $this->response(true);
    }
    
    public function clearTj()
    {
        $ids = $_POST['ids'];
        $business = new HomeTjDataBusiness();
        $business->clearTj($ids);
        $this->response(true);
    }
    
    public function clearHot()
    {
        $ids = $_POST['ids'];
        $business = new HomeTjDataBusiness();
        $business->clearHot($ids);
        $this->response(true);
    }
}