<?php 

class NetDataAjaxView extends AjaxCoreLib
{
	
	public function del()
	{
		$ids = empty($_POST['ids']) ? array() : $_POST['ids'];
		if (!$ids)
		{
			return;
		}
		$business = new NetDataBusiness();
		$business->setState($ids, NetDataDataModel::STATUS_NO);
		$this->response(true);
	}
}