<?php 

class TuanAjaxView extends AjaxCoreLib
{
	
	public function getRegionByCiy()
	{
		if (empty($_POST['id']))
		{
			return;
		}
		$business = new NetTuanBusiness();
		$cityRegionModels = $business->getCityRegion($_POST['id']);
		$this->response($cityRegionModels);
	}
    
    public function changeIstj()
    {
        $id = $_POST['id'];
        $istj = (int)$_POST['istj'];
        $business = new NetTuanBusiness();
        $business->changeIstj($id,$istj);
        $this->response(true);
    }
    
    public function del()
    {
        $id = $_POST['id'];
        $business = new NetTuanBusiness();
        $business->del($id);
        $this->response(true);
    }
}