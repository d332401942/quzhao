<?php 
class IndexLoginView extends BaseView
{
    
    public function __construct()
    {
        parent::__construct(false);
    }
    
    public function index()
    {
        if ($_POST)
        {
            $userName = $_POST['username'];
            $passWord = $_POST['password'];
            $verify = $_POST['verify'];
            if ($verify != VerifyUtilLib::getVerifyCode())
            {
                $this->responseError('验证码不正确！');
            }
            if (empty($userName))
            {
                $this->responseError('请填写用户名！');
            }
            $business = M('AdminUserBusiness');
            $ip = $_SERVER['SERVER_ADDR'];
            $userInfo = $business->login($userName,$passWord,$ip);
            if (empty($userInfo))
            {
                $this->responseError('账号或者密码错误！');
            }
            $this->setUserCookie($userInfo);
        }
    }
    
    private function setUserCookie($userInfo)
    {
        $userArr = $userInfo->toArray();
        unset($userArr['PassWord']);
        $jsonStr = json_encode($userArr);
        CommUtilLib::setCookie('UserInfo', $jsonStr);
        $this->redirect(APP_URL);
    }
    
}