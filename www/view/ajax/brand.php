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
}
?>