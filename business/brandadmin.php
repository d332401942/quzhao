<?php
class BrandadminBusiness extends BaseBusiness
{
	 public function login($userName,$passWord)
    {
        $userInfo = $this->getUserInfo($userName, $passWord);
        if (empty($userInfo))
        {
            return false;
        }
		$model = json_encode( $userInfo);
		setcookie('brandModel',$model,time()+86400,'/');
		setcookie('brand_id',$userInfo->id,time()+86400,'/');
		setcookie('brand_name',$userInfo->username,time()+86400,'/');
		return $userInfo;
    }
	
	public function getUserInfo($userName,$passWord)
    {
        $data = M('BrandadminData');
        $userInfo = $data->getUserInfo($userName,$passWord);
        return $userInfo;
    }
}

?>