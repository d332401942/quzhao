<?php 

class DemoContentView extends BaseView
{
	
	public function index()
	{
		$netDataBusiness = new NetDataBusiness();
		$models = $netDataBusiness->demo();
		$array = array();
		foreach ($models as $model)
		{
			$array[] = $model->id;
		}
		$json = json_encode($array);
		$this->assign('json',$json);
		$this->assign('title', 'demo');
	}
}