<?php

class MerchantsAjaxView extends BaseAjaxView
{

   public function del()
	{
		$ids = empty($_POST['ids']) ? array() : (int)$_POST['ids'];
		$business = new MerchantsBusiness();
		$business->del($ids);
		$this->response(true);
	}

}

