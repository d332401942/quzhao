<?php

class BaseView extends ViewCoreLib
{
    
	protected $Host;

	public function __construct()
	{
		parent::__construct();
		$this->Host = new HostModel();
		$this->assign('Host', $this->Host);
	}
    
    public function setMeta($title = '趣找购物搜索', $keywords= '趣找购物搜索' ,$description = '趣找购物搜索')
    {
        $meta = new MetaModel();
        $meta->Title = $title;
        $meta->Keywords = $keywords;
        $meta->Description = $description;
        $this->assign('meta', $meta);
    }
}
