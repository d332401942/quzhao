<?php 

class BaseCallbakView extends BaseView
{
	
	protected function gotoSet($userModel)
	{
		//把用户信息记入cookie
		$userUtility = new UserUtility();
		$userUtility->setViewUser($userModel);
		if (!empty($_GET['fromurl']))
		{
			$formUrl = urldecode($_GET['fromurl']);
			
			$this->redirect($formUrl);
		}
	}
}