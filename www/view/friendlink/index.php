<?php

class IndexFriendlinkView extends BaseView
{
    
    public function index()
    {
		$this->cache('cacheData');
    }
    
    public function cacheData()
    {
        $footerBusiness = new FooterBusiness();
        $titleModels = $footerBusiness->findTitle();
        $this->assign('titleModels', $titleModels);
		$business = M('FriendLinkBusiness');   
		$models = $business->findAll();
		if (!$models)
		{
			$models = array();
		}
		$this->assign('models', $models);
    }
}
