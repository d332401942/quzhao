<?php

class AdminUserBusiness extends BaseBusiness
{
    
    public function login($userName,$passWord,$ip)
    {
        $userInfo = $this->getUserInfo($userName, $passWord);
        if (!$userInfo)
        {
            return false;
        }
        //更改登录信息
        $userInfo->LastLoginIp = $ip;
        $userInfo->LastLoginTime = time();
        $userInfo->setWorkFields(array('LastLoginIp','LastLoginTime'));
       
        $data = M('AdminUserData');
        $data->updateModel($userInfo);
        return $userInfo;
    }
    
    public function getUserInfo($userName,$passWord)
    {
        $data = M('AdminUserData');
        $userInfo = $data->getUserInfo($userName,$passWord);
        return $userInfo;
    }
}