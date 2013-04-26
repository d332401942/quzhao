<?php

class ChildcateAjaxView extends BaseAjaxView
{

   public function del()
	{
		$ids = empty($_POST['ids']) ? array() : (int)$_POST['ids'];
		$business = new Child_cateBusiness();
		$business->del($ids);
		$this->response(true);
	}

}

