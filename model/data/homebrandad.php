<?php

/**
 * 广告实体
 * @author Administrator
 *
 */
class HomeBrandAdDataModel extends BaseDataModel
{
	/**
	 * 广告位置：首级超值单品
	 * @var int
	 */
	const STYPE_POSITION_DB_INDEX = 0;
	
	/**
	 * 广告位置：团购顶部
	 */
	const STYPE_POSITION_TUAN_BOTTOM = 1;
	
	/**
	 * 广告位置：品牌特卖右上部
	 */
	const STYPE_POSITION_BRAND_RIGHT_TOP = 2;
	
	/**
	 * 广告位置：超级单品页顶部
	 */
	const STYPE_POSITION_DB_BOTTOM = 3;
	
	/**
	 * 广告名称
	 * 
	 * @var int
	 */
	public $name;
	
	/**
	 * 是否投放代码
	 * 
	 * @var int
	 */
	public $ishtml;
	
	/**
	 * 广告位置
	 * 
	 * @var int
	 */
	public $stype;
	
	/**
	 * 广告图片
	 * 
	 * @var int
	 */
	public $pic;
	
	/**
	 * 广告连接
	 * 
	 * @var int
	 */
	public $href;
	
	/**
	 * 价格
	 */
	public $price;
	
	/**
	 * 排序
	 * 
	 * @var int
	 */
	public $sort;
	
	/**
	 * 是否有效
	 * 
	 * @var int
	 */
	public $isvalid;

	public function __construct()
	{
		parent::__construct();
		$this->setTableName('home_brand_ad');
	}

	/**
	 * 得到广告位说明
	 */
	public static function getStype()
	{
		return array(
				self::STYPE_POSITION_DB_INDEX => '首级超值单品',
				self::STYPE_POSITION_TUAN_BOTTOM => '团购顶部',
				self::STYPE_POSITION_BRAND_RIGHT_TOP => '品牌特卖右上部',
				self::STYPE_POSITION_DB_BOTTOM => '超级单品页顶部',
		);
	}
}