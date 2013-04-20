<?php

class BaseView extends ViewCoreLib
{
    
    const USER_INFO_COOKIE_KEY = 'UserInfo';
    
	protected $Host;
	
	protected $CurrentUser;
	
	protected $ServerName;

	public function __construct()
	{
		parent::__construct();
		$this->ServerName = $_SERVER['SERVER_NAME'];
		$this->getCookieUserInfo();
		$this->Host = new HostModel();
		$this->assign('Host', $this->Host);
		$this->assign('CurrentUser', $this->CurrentUser);
		$this->assign('ServerName',$this->ServerName);
	}
	
	public function getDetailUserInfo()
	{
	    if (!$this->CurrentUser)
	    {
	        return null;
	    }
	    $userId = $this->CurrentUser->id;
	    $business = M('UserBusiness');
	    $userModel = $business->getOneById($userId);
	    return $userModel;
	}
	
    protected function setMeta($title = '趣找购物搜索', $keywords= '趣找购物搜索' ,$description = '趣找购物搜索')
    {
        $meta = new MetaModel();
        $meta->Title = $title;
        $meta->Keywords = $keywords;
        $meta->Description = $description;
        $this->assign('meta', $meta);
    }
    
    private function getCookieUserInfo()
    {
        if (empty($_COOKIE[self::USER_INFO_COOKIE_KEY]))
        {
            return null;
        }
        $userArr = json_decode($_COOKIE[self::USER_INFO_COOKIE_KEY], true);
        $userModel = new UserDataModel();
        $userModel->loadArray($userArr);
        $this->CurrentUser = $userModel;
    }
}
