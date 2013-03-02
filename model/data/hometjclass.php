<?php

class HomeTjClassDataModel extends BaseDataModel
{

	const IS_USE_TYPE_YES = 1;
	
	const IS_USE_TYPE_NO = 0;
	
	/**
	 * 父id
	 * @var int
	 */
	public $pid;
	
	/**
	 * 分类名称
	 * @var varchar(50)
	 */
	public $name;
	
	/**
	 * 是否使用
	 * @var tinyint
	 */
	public $isuse;
	
	/**
	 * 排序
	 * @var in
	 */
	public $sort;
	
	/**
	 * 对应的子分类
	 * @var array
	 */
	public $children = array();
	
	
	public function __construct()
	{
		parent::__construct();
		$this->setTableName('home_tj_class');
		$this->setIgoneFields('children');
	}
}