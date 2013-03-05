<?php

class HomeBrandData extends BaseData
{
	
	/**
	 * 得到热门品牌数据
	 */
	public function getHotHomeBrandModels()
	{
		$sql = 'select * from home_brand where ishot = '.HomeBrandDataModel::IS_HOT_YES . ' order by sort desc limit 16';
		return $this->query($sql,'HomeBrandDataModel');
	}
	
	/**
	 * 得到首页品牌特卖的数据
	 */
	public function getIndexBrandDataModels()
	{
		$sql = 'select *,t2.pic,t1.id as id from home_brand_data as t1 inner join home_brand as t2 on t1.bid = t2.id where t1.istj = '. HomeBrandDataDataModel::ISTJ_IS .' and time_end > '.time().' and time_start < '.time().' limit 3';
		return $this->query($sql,'HomeBrandDataDataModel');
	}
	
	/**
	 * 得到首页品牌特卖的数据
	 * @param int $start 开始取
	 * @param int $end 取几条
	 */
	public function getIndexBrandData($start, $end)
	{
		$sql = 'select *,t2.pic from home_brand_data as t1 inner join home_brand as t2 on t1.bid = t2.id where time_end > '.time().' limit '.$start.','.$end;
		return $this->query($sql,'HomeBrandDataDataModel');
	}
}