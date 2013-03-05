<?php

class HomeBrandDataModel extends BaseDataModel
{
	
	/**
	 * 是否显示在首页热门品牌：是
	 * @var int
	 */
	const IS_HOT_YES = 1;
	
	/**
	 * 是否显示在首页热门品牌：否
	 * @var int
	 */
	const IS_HOT_NO = 0;
	
	public $name;
	
	public $href;
	
	public $pic;
	
	public $sort;
	
	/**
	 * 简介
	 * @var unknown_type
	 */
	public $info;
	
	/**
	 * 是否首页热门品牌
	 * @var unknown_type
	 */
	public $ishot;
	
	public function __construct()
	{
		parent::__construct();
		$this->setTableName('home_brand');
	}
}