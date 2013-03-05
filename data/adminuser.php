<?php

class AdminUserData extends BaseData
{
    
    public function getUserInfo($userName, $passWord)
    {
        $query = array();
        $query1 = array();
        $query['UserName']['='] = $userName;
        $query['PassWord']['='] = md5($passWord);
        $result = $this->where($query)->findOne();
        return $result;
    }
}

