<?php 

class Child_cateAjaxView extends BaseAjaxView
{
	public function getCateId()
	{
		if($_POST)
		{
			$business = M('Child_cateBusiness');
			$resutl = $business->getAll((int)$_POST['cateId']);
			$this->response($resutl);
		}
	}
}