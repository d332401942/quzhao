<?php

class IndexFriendlinkView extends BaseView
{
	
	public function index()
	{
		$this->assign('title', '友情链接');
		$business = M('FriendLinkBusiness');
		$models = $business->findAll();
		if (!$models)
		{
			$models = array();
		}
		$this->assign('models', $models);
	}
}
