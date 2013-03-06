<?php

class NetTuanBusiness extends BaseBusiness
{
	
	/**
	 * 得打团购数据
	 * @param unknown_type $pageCore
	 * @param bool $isInnerTime 是否查询开始时间和结束时间在范围内的
	 * @return Ambigous <boolean, unknown>
	 */
	public function getTuanModels($pageCore,$city = null,$region = null,$class = null,$class2 = null,$sort = array(),$keyword = null)
	{
		$data = new NetTuanData('NetTuanDataDataModel');
		$data->setPage($pageCore);
		$query = array();
        if ($city) 
        {
            $query['s_city_id'] = $city;
        }
		if ($region)
		{
			$query['s_region_id'] = $region;
		}
		if ($keyword)
		{
			$query['name'] = array('like' => '%'.$keyword.'%');
		}
		if ($class)
		{
			//查找今天发布的
			if ($class == 1)
			{
				$dayTime = strtotime(date('Y-m-d'));
				$query['ctime'] = array('>=' => date('Y-m-d H:i:s',$dayTime));
			}
			else 
			{
				$query['s_class_1'] = $class;
			}
		}
		if ($class2)
		{
			$query['s_class_2'] = $class2;
		}
		$query['end_time'] = array('>' => date('Y-m-d H:i:s'));
		$query['isvalid'] = NetTuanDataDataModel::ISVALID_YES;
		if ($query)
		{
			$data->where($query);
		}
		if ($sort)
		{
			$data->setOrder($sort);
		}
		$models = $data->findAll();
		return $models;
	}
	
	public function getCity()
	{
		$data = new NetTuanData('NetTuanDataDataModel');
		return $data->getCity();
	}
	
	/**
	 * 得到所有根分类
	 */
	public function getRootClassModels()
	{
		$data = new NetTuanData('NetTuanClassDataModel');
		$data->where(array('pcode' => 0));
		$data->setOrder(array('sort' => 'desc'));
		return $data->findAll();
	}
	
	public function getAllClassModels()
	{
		$data = new NetTuanData('NetTuanClassDataModel');
		$data->setOrder(array('sort' => 'desc'));
		$result = $data->findAll();
		$rootModels = array();
		$pcodeToModels = array();
		foreach ($result as $model) {
			$pcodeToModels[$model->pcode][] = $model;
			if (!$model->pcode)
			{
				$rootModels[] = $model;
			}
		}
		foreach ($rootModels as $model)
		{
			if (isset($pcodeToModels[$model->code]))
			{
				$model->children = $pcodeToModels[$model->code];
			}
		}
		return $rootModels;
	}
	
	/**
	 * 根据城市获得地区
	 * @param unknown_type $currentCityCode
	 * @return Ambigous <boolean, unknown>
	 */
	public function getCityRegion($currentCityCode)
	{
		$data = new NetTuanData('NetTuanRegionDataModel');
		$data->where(array('pid' => $currentCityCode));
		$data->setOrder(array('sort' => 'desc'));
		return $data->findAll();
	}
    
	public function getCityById($id)
	{
		$data = new NetTuanData('NetTuanCityDataModel');
		return $data->getOneById($id);
	}
    
    public function changeIstj($id,$istj)
    {
        $data = new NetTuanData('NetTuanDataDataModel');
        $data->changeIstj($id,$istj);
    }
    
    public function getRecommend()
    {
        $data = new NetTuanData('NetTuanDataDataModel');
        $data->where(array('istj' => 1));
        $data->setOrder(array('id' => 'desc'));
        return $data->findAll();
    }
    
    public function del($id)
    {
        $data = new NetTuanData('NetTuanDataDataModel');
        $data->delById($id);
    }
    
    /**
     * 得到首页的6个 团购信息
     */
    public function getIndexTuanModels()
    {
        $data = new NetTuanData('NetTuanDataDataModel');
        $data->where(array('istj' => 1));
        $data->setLimit(array(0,6));
        $data->setOrder(array('id' => 'desc'));
        return $data->findAll();
    }

	public function changeStatus($id, $status)
	{
		$data = new NetTuanData('NetTuanDataDataModel');
		$data->changeStatus($id, $status);
	}
}
