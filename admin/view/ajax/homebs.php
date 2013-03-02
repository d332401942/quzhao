<?php 

class HomebsAjaxView extends AjaxCoreLib
{
	
	public function delClass()
	{
		$id = $_POST['id'];
		$business = new HomeBsClassBusiness();
		$business->del($id);
	}
	
	public function delData()
	{
		$id = $_POST['id'];
		$business = new HomeBsDataBusiness();
		$business->del($id);
		if (!empty($_POST['href']))
		{
			$pic = $_POST['href'];
			if (file_exists($pic))
			{
				unlink($pic);
			}
		}
	}
    
    public function updateClassSort()
    {
        $id = $_POST['id'];
        $value = $_POST['value'];
        $business = new HomeBsDataBusiness();
        $business->updateClassSort($id,$value);
        $this->response(true);
    }
    
    public function updateClassName()
    {
        $id = $_POST['id'];
        $value = $_POST['value'];
        $business = new HomeBsDataBusiness();
        $business->updateClassName($id,$value);
        $this->response(true);
    }
}