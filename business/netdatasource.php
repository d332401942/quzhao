<?php

class NetDataSourceBusiness extends BaseBusiness
{
	
	
	public function getByName($name)
	{
		$data = new NetDataSourceData();
		$data->where(array('name' => $name));
		return $data->findOne();
	}
	
	public function add($model)
	{
		$data = new NetDataSourceData();
		$data->add($model);
	}
	
	public function updateModel($model)
	{
		$data = new NetDataSourceData();
		$data->updateModel($model);
	}
	
	public function findAll($isuse = array(NetDataSourceDataModel::IS_USE_NO,NetDataSourceDataModel::IS_USE_YES))
	{
		$data = new NetDataSourceData();
		$query = array('isuse' => array('in' => $isuse));
		$data->where($query);
		$result = $data->findAll();
		return $result;
	}
	
	public function getFromSiteName($href)
	{
		$array = array(
			'/jd.com/' => '京东商城',	
			'/360buy.com/' => '京东商城',	
			'/taobao.com/' => '淘宝',	
		);
		foreach ($array as $pattern => $name)
		{
			if (preg_match($pattern, $href))
			{
				return $name;
			}
		}
		return '趣找网';
	}
    
    public function getOneById($id)
    {
        $data = new NetDataSourceData();
        return $data->getOneById($id);
    }
}