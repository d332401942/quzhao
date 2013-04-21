<?php 

class BaseCallbakView extends BaseView
{
	const APP_ID_QQ = '100384287';
	
	const APP_KEY_QQ = 'b17db4b2e78d8b99ff322098a942736d';
	
	protected $redirectUriQQ;
	
	public function __construct($isCheck = true)
	{
		parent::__construct($isCheck);
		$this->redirectUriQQ = 'http://' . $this->ServerName . '/callbak/qq';
	}
}