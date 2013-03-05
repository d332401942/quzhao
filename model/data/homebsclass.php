<?php


/**
 * 合作商家分类
 * @author Administrator
 *
 */
class HomeBsClassDataModel extends BaseDataModel
{
	
	public $name;
	
	public $sort;
	
	/**
	 * 对应商家datamodel
	 * @var unknown_type
	 */
	public $data = array();
	
	public function __construct()
	{
		parent::__construct();
		$this->setTableName('home_bs_class');
		$this->setIgoneFields('data');
	}
}