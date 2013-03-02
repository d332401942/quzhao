<?php 

/**
 * 合作商家数据
 * @author Administrator
 *
 */
class HomeBsDataDataModel extends BaseDataModel
{
	
	/**
	 * 商家分类ID 对应home_bs_class表
	 * @var int
	 */
	public $bid;
	
	public $name;
	
	public $pic;
	
	public $href;
	
	public $sort;
	
	public function __construct()
	{
		parent::__construct();
		$this->setTableName('home_bs_data');
	}
}