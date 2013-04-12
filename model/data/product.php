<?php

class ProductDataModel extends ModelCoreLib
{

	public $productid;
	
	public $brandid;

	public $siteid;

	public $cityid;

	public $categoryid;

	public $groupid;

	public $sourceid;

	public $markettime;

	public $title;

	public $title2;

	public $url;

	public $pic;

	public $price;

	public $costs;

	public $info;

	public $sitename;

	public $shopname;

	public $brandname;

	public $weight;

	public $sales;

	public $favs;

	public $reviews;

	public $rankcount;

	public $ranks;

	public $haves;

	public $loves;

	public $createtime;

	public $isdelete;

	public $isupdate;

	public $lighttitle;
	
	public function __construct()
	{
		parent::__construct();
		$this->setPrimaryKey('productid');
		$this->setIgoneFields('lighttitle');
	}
}
