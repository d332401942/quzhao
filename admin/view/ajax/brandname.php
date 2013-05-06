<?php
class BrandnameAjaxView extends BaseAjaxView
{
	public function del()
	{
		if(!empty($_POST['ids']) && (int)$_POST['ids'])
		{
			$buesiness = M('BrandnameBusiness');
			$buesiness->deleteBrand($_POST['ids']);
			$this->response(true);
		}
		
	}
}
?>