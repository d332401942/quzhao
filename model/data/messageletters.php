<?php

class MessagelettersDataModel extends BaseDataModel
{

	/**
	 * 商品类型：9.9
	 * 
	 * @var unknown
	 */
	const TYPE_NINE = 1;

	/**
	 * 商品类型：超值单品
	 * 
	 * @var unknown
	 */
	const TYPE_DP = 2;

	/**
	 * 用户ID
	 * 
	 * @var unknown
	 */
	public $userid;

	/**
	 * 商品ID
	 * 
	 * @var unknown
	 */
	public $pid;

	/**
	 * 商品类型
	 * 
	 * @var unknown
	 */
	public $type;

	/**
	 * 添加时间
	 * 
	 * @var unknown
	 */
	public $createtime;

	/**
	 * 查看时间
	 * 
	 * @var unknown
	 */
	public $readtime;

	/**
	 * 是否查看
	 * 
	 * @var unknown
	 */
	public $isread;

	public function __construct()
	{
		parent::__construct ();
		$this->setTableName ( 'messageletters' );
	}

}