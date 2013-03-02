<?php 
class AdminUserDataModel extends BaseDataModel
{
    
    /**
     * 用户名
     * @var unknown_type
     */
    public $UserName;
    
    /**
     * 密码
     * @var unknown_type
     */
    public $PassWord;
    
    /**
     * 上次登录IP
     * @var unknown_type
     */
    public $LastLoginIp;
    
    /**
     * 上次登录时间
     * @var unknown_type
     */
    public $LastLoginTime;
}