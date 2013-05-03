<?php
class BrandAjaxView extends BaseAjaxView
{
	public function del()
	{
		if(!empty($_POST['ids']) && (int)$_POST['ids'])
		{
			$buesiness = M('BrandBusiness');
			$buesiness->deleteBrand($_POST['ids']);
			$this->response(true);
		}
		
	}
	
	public function getAll()
	{
		if(!empty($_POST['val']))
		{
			$keywords = trim($_POST['val']);
			$buesiness = M('BrandnameBusiness');
			$result = $buesiness->getKeywords($keywords);
			$this->response($result);
		}
	}
	
	public function changeState()
	{
		$ids = array();
		if (! empty($_POST ['ids']))
		{
			$ids = $_POST ['ids'];
		}
		$state = ( int ) $_POST ['state'];
		$buesiness = M('BrandBusiness');
		$buesiness->changeState($ids, $state);
		$this->response(true);
	}
}
?>