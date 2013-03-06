<?php

class FriendLinkAjaxView extends AjaxCoreLib
{

	public function del()
	{
		$id = $_POST['id'];
		$business = M('FriendLinkBusiness');
		$business->delById($id);
		$this->respose(true);
	}

	
}
