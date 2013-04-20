<?php

class ShareAjaxView extends AjaxCoreLib
{

	public function del()
	{
		$ids = empty($_POST['ids']) ? array() : $_POST['ids'];
		if (!$ids)
		{
			return;
		}
		$business = new ShareBusiness();
		$business->setState($ids, ShareDataModel::SHARE_STATUS_DELETE);
		$this->response(true);
	}

}

