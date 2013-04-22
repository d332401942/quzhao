<?php 

class BaseCallbakView extends BaseView
{
	
	protected function gotoSet($userModel)
	{
		setcookie ( BaseView::USER_INFO_COOKIE_KEY, json_encode ( $userModel ), 0, '/' );
	}
}