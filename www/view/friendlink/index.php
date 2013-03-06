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
		$this->assign('models', $models);
    }
}
