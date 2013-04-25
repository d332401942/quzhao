<?php 

class LoginBrandadminView extends BaseView
{
	
	public function index()
	{
		if(!empty($_COOKIE['brand_id']) && !empty($_COOKIE['brandModel']))
		{
			$this->redirect(APP_URL . '/brandadmin');
		}
		if ($_POST)
        {
            $userName = $_POST['username'];
            $passWord = $_POST['password'];
            if (empty($userName))
            {
				die('请填写用户名！');
            }
			if (empty($passWord))
            {
				die('请填密码！');
            }
            $business = M('BrandadminBusiness');
            $userInfo = $business->login($userName,$passWord);
            if (empty($userInfo))
            {
				die('账号或者密码错误！');
            }
			$this->redirect(APP_URL . '/brandadmin');
        }
	}
}