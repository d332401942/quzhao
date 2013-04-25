<?php

class BrandadminData extends BaseData
{
    
    public function getUserInfo($userName, $passWord)
    {
        $query = array();
        $query['username']['='] = $userName;
        $query['password']['='] = md5($passWord);
        $result = $this->where($query)->findOne();
        return $result;
    }
}

