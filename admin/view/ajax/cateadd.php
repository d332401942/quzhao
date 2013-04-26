<?php

class CateaddAjaxView extends BaseAjaxView
{

   public function del()
	{
		$ids = empty($_POST['ids']) ? array() : (int)$_POST['ids'];
		$business = new Brand_cateBusiness();
		$business->del($ids);
		$this->response(true);
	}

}

