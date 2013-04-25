<?php 
class BrandadminDataModel extends BaseDataModel
{
    
    /**
     * 用户名
     * @var unknown_type
     */
    public $username;
    
    /**
     * 密码
     * @var unknown_type
     */
    public $password;
   

	public function __construct()
	{
		parent::__construct();
		$this->setTableName('brandadmin');
	}
}
