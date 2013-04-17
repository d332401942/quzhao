<?php
class AddUserView extends BaseView
{
	public function index()
	{
		$business = M('UserBusiness');
		$business->register();
	}
}
?>