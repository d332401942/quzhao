<?php

class MessageAjaxView extends AjaxCoreLib
{

	public function del()
	{
		$ids = empty($_POST['ids']) ? array() : $_POST['ids'];
		if (!$ids)
		{
			return;
		}
		$business = new MessageBusiness();
		$business->deleteMessage($ids);
		$this->response(true);
	}

}

