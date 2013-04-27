<?php

class HomeTjDataDataModel extends BaseDataModel
{
	
	/**
	 * 商品状态：无货
	 * @var int
	 */
	const STATE_EMPTY = 2;
	
	/**
	 * 商品状态：有货
	 * @var int
	 */
	const STATE_HAVE = 1;
	
	/**
	 * 商品状态：下线
	 */
	const STATE_DOWN = 0;
	
	/**
	 * 来源：手工输入
	 * @var int
	 */
	const FID_HAND_INPUT = 0;
	
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
	 * 是否有限：是
	 * @var int
	 */
	const ISVALID_YES = 1;
	
	/**
	 * 是否有限：否
	 * @var int
	 */
	const ISVALID_NO = 0;
	
	
	/**
	 * 所属分类ID
	 * @var int
	 */
	public $cid;
	
	/**
	 * 商品来源网站ID默认为0
	 * @var int
	 */
	public $fid;
	
	/**
	 * 抓取数据网站
	 * @var int
	 */
	public $site;
	
	/**
	 * 商品名称
	 * @var varchar(400)
	 */
	public $name;
	
	/**
	 * 附标题
	 * @var varchar(400)
	 */
	public $title;
	
	/**
	 * 商品简介
	 * @var varchar(4000)
	 */
	public $info;
	
	/**
	 * 备注
	 * @var varchar(400)
	 */
	public $remark;
	
	/**
	 * 图片链接
	 * @var varchar(200)
	 */
	public $pic;
	
	/**
	 * 商品链接
	 * @var varchar(200)
	 */
	public $href;
	
	/**
	 * 商品原价格
	 * @var numeric(18,2)
	 */
	public $sprice;
	
	/**
	 * 商品目前价格
	 * @var numeric(18,2)
	 */
	public $price;
	
	/**
	 * 邮费
	 * @var numeric(18,2)
	 */
	public $eprice;
	
	
	/**
	 * 当前状态 是否可以抢购 0无货 1有货
	 * @var int
	 */
	public $state;
	
	/**
	 * 是否有效
	 * @var int
	 */
	public $isvalid;
	
	/**
	 * 是否推荐
	 * @var int
	 */
	public $istj;
    
    /**
     * 是否在超值单品列热门中显示
     * @var int
     */
    public $ishot;
	
	/**
	 * 排序
	 * @var int
	 */
	public $sort;
	
	/**
	 * 开始时间
	 * @var unknown_type
	 */
	public $time_start;
	
	/**
	 * 结束时间
	 * @var unknown_type
	 */
	public $time_end;
	
	/**
	 * 建立日期
	 * @var unknown_type
	 */
	public $ctime;
	
	/**
	 * 最后更新日期
	 * @var int
	 */
	public $ltime;
	
	/**
	 * 会员分享关联id
	 * @var int
	 */
	public $shareid = 0;
	
	/**
	 * 会员喜欢次数
	 * @var int
	 */
	public $lovenumber = 0;
	
	/**
	 * 商品适合性别
	 */
	public $fitsex;
	
	/**
	 * 分享商品会员id
	 */
	public $userid;
	
	/**
	 * 1是兼职添加的东西，临时字段
	 */
	public $tempType = 0;
	
	
	/**
	 * 网站来源名称
	 */
	public $fromName;
	
	public $username;
	
	public function __construct()
	{
		parent::__construct();
		$this->setTableName('home_tj_data');
	}
}