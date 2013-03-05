<?php 

class NetDataDataModel extends BaseDataModel
{
	
	
	/**
	 * 类别：9.9包邮
	 */
	const CLASS_ID_TYPE_NINE = 0;
	
	/**
	 * 类别：超值单品
	 */
	const CLASS_ID_TYPE_DP = 1;
	
	const STATUS_YES = 1;
	
	const STATUS_NO = 0;
	
	
	/**
	 * 类别 0=9.9包邮 1=超值单品
	 * @var int
	 */
	public $classid;
	
	/**
	 * 对应商品分类ID 
	 * @var int
	 */
	public $home_tj_class_id;
	
	/**
	 * 对应抓取网站ID
	 * @var int
	 */
	public $net_data_site_id;
	
	/**
	 * 对应商品网站ID
	 * @var int
	 */
	public $net_data_source_id;
	
	/**
	 * 来源
	 * @var varchar(20)
	 */
	public $site;
	
	/**
	 * 显示名称
	 * @var varchar(200)
	 */
	public $name;
	
	/**
	 * 图片
	 * @var varchar
	 */
	public $pic;
	
	/**
	 * 简介
	 * @var varchar(4000)
	 */
	public $info;
	
	/**
	 * 来源URL
	 * @var varchar(200)
	 */
	public $href;
	
	/**
	 * 分类 1
	 * @var varhcar(20) 
	 */
	public $class1;
	
	/**
	 * 分类 2
	 * @var varhcar(20) 
	 */
	public $class2;
	
	/**
	 * 分类 3
	 * @var varhcar(20) 
	 */
	public $class3;
	
	/**
	 * 入库时间
	 * @var datetime 
	 */
	public $ctime;
	
	/**
	 * 更新时间
	 * @var datetime 
	 */
	public $ltime;
	
	/**
	 * 状态
	 * @var int
	 */
	public $state;
	
	/**
	 * 数据库中分类id
	 * @var int
	 */
	public $tjClassid;
	
	
	public function __construct()
	{
		parent::__construct();
		$this->setTableName('net_data');
		$this->setIgoneFields('tjClassid');
	}
	
}