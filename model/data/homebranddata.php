<?php 

class HomeBrandDataDataModel extends BaseDataModel
{
	
	/**
	 * 是否推荐：推荐
	 * @var int
	 */
	const ISTJ_IS = 1;
	
	/**
	 * 是否推荐：推荐
	 * @var int
	 */
	const ISTJ_NO = 0;
	
	/**
	 * 所属品牌ID
	 * @var int
	 */
	public $bid;
	
	/**
	 * 标题1
	 * @var string
	 */
	public $title1;
	
	/**
	 * 标题2
	 * @var string
	 */
	public $title2;
	
	/**
	 * 标题3
	 * @var string
	 */
	public $title3;
	
	/**
	 * 推荐图片
	 * @var string
	 */
	public $tjpic;
	
	/**
	 * 推荐连接
	 * @var string
	 */
	public $tjhref;
	
	public $time_start;
	
	public $time_end;
	
	public $istj;
	
	public $sort;
	
	/**
	 * 品牌的图片对应品牌表
	 * @var unknown_type
	 */
	public $pic;
	
	public function __construct()
	{
		parent::__construct();
		$this->setTableName('home_brand_data');
		$this->setIgoneFields('pic');
	}
}