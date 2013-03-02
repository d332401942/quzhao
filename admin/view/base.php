<?php

class BaseView extends ViewCoreLib
{
    
    public $userInfo;
    
    public function __construct($isCheck = true)
    {
        if ($isCheck)
        {
            $this->checkUserIsLogin();
        }
        parent::__construct();
    }
    
    public function checkUserIsLogin()
    {
        if (empty($_COOKIE['UserInfo']))
        {
            $this->redirect(APP_URL.'/login/');
        }
        $userInfo = json_decode($_COOKIE['UserInfo'],true);
        $userModel = new AdminUserDataModel();
        foreach ($userInfo as $key => $val)
        {
            $userModel->$key = $val;
        }
        $this->userInfo = $userModel;
    }
    
    public function success($msg = '操作成功',$url = '')
    {
    	if ($url)
    	{
    		$url = urlencode($url);
    	}
    	header('Location: '.APP_URL .'/index/msg?mark=1&msg='.$msg.'&url='.$url);
    	exit;
    }
    
}