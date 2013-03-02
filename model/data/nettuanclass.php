<?php 

class NetTuanClassDataModel extends ModelCoreLib
{
    
    public $code;
    
    public $name;
    
    public $nickname;
    
    public $pcode;
    
    public $sort;
    
    /**
     * 对应自己的下级
     * @var array();
     */
    public $children = array();
    
    public function __construct()
    {
        parent::__construct();
        $this->setTableName('net_tuan_class');
        $this->setIgoneFields('children');
    }
}