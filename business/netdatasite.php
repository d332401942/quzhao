<?php 

/**
 * 抓取数据网站
 */

class NetDataSiteBusiness extends BaseBusiness
{
	
	public function findAll($isuse = array(NetDataSiteDataModel::IS_USE_TYPE_NO,NetDataSiteDataModel::IS_USE_TYPE_YES))
	{
		$data = new NetDataSiteData();
		$data->where(array('isuse' => array('in' => $isuse)));
		return $data->findAll();
	}
	
	public function findByName($name)
	{
		$data = new NetDataSiteData();
		
		$data->where(array('name' => $name));
		return $data->findOne();
	}
	
	public function add($model)
	{
		$data = new NetDataSiteData();
		$data->add($model);
	}
	
	public function updateModel($model)
	{
		$data = new NetDataSiteData();
		$data->updateModel($model);
	}
}