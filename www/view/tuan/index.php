<?php 

class IndexTuanView extends BaseView
{
	
	public function index($parameters)
	{
		$this->setMeta();
		//得到城市信息
		$cityModels = $this->getCity();
		$hotCityModels = array();
		$cityHead = array();
		$headToModels = array();
		foreach ($cityModels as $model)
		{
			if ($model->flag) 
			{
				$hotCityModels[] = $model;
			}
			$he = strtoupper($model->head);
			$headToModels[$he][] = $model;
			$cityHead[] = $he;
		}
		$cityHead = array_unique($cityHead);
		sort($cityHead);
		ksort($headToModels);
		//得到分类信息
		$this->classModels = $this->getClassModels();
		//TODO 获取当前城市
		
		//默认字母
		$headLetter = 'L';
		
		//得到广告
		$adModels = $this->getAdModels();
        //得到团购数据
        $models = $this->getModels($parameters);
        $this->assign('models', $models);
		$this->assign('headLetter',$headLetter);
		$this->assign('hotCityModels',$hotCityModels);
		$this->assign('headToModels',$headToModels);
		$this->assign('cityHead',$cityHead);
		$this->assign('classModels',$this->classModels);
		$this->assign('adModels',$adModels);
	}
    
    private function getModels($parameters)
    {
        $pageCore = new PageCoreLib();
        $pageCore->pageSize = 21;
        $pageCore->currentPage = (!empty($parameters['page']) && (int)$parameters['page']) ? (int)$parameters['page'] : 1;
        //TODO 默认为北京以后根据IP判断
        $city = !empty($parameters['city']) ? $parameters['city'] : 10100;
        $region = !empty($parameters['region']) ? $parameters['region'] : null;
        $class1 = !empty($parameters['class1']) ? $parameters['class1'] : null;
        $class2 = !empty($parameters['class2']) ? $parameters['class2'] : null;
        $sortStr = !empty($parameters['sort']) ? $parameters['sort'] : null;
        $keyword = !empty($parameters['keyword']) ? $parameters['keyword'] : null;
        $sort = array();
        $sort['id'] = 'desc';
		switch ($sortStr)
		{
			case 'bought':
				$sort['bought'] = 'desc';
				break;
			case 'cur_price':
				$sort['cur_price'] = 'asc';
				break;
			case 'id':
				$sort['id'] = 'desc';
				break;
            default :
				$sort['id'] = 'desc';
				break;
		}
		//根据当前城市获取城市地区
		$regionModels = $this->getCityRegion($city);
        //得到城市名称
        $cityName = $this->getCityName($city);
        //得到小类
        $classModels2 = $this->getClassModels2($class1);
        
        $business = new NetTuanBusiness();
        $models = $business->getTuanModels($pageCore,$city,$region,$class1,$class2,$sort,$keyword);
        $this->assign('classModels2', $classModels2);
        $this->assign('regionModels', $regionModels);
        $this->assign('city', $city);
        $this->assign('cityName', $cityName);
        $this->assign('region', $region);
        $this->assign('keyword', $keyword);
        $this->assign('class1', $class1);
        $this->assign('class2', $class2);
        $this->assign('sortStr', $sortStr);
        $this->assign('pageCore',$pageCore);
        return $models;
    }
    
	private function getClassModels2($code)
    {
        $business = new NetTuanBusiness();
        $codeToModels = array();
        foreach ($this->classModels as $model)
        {
            $codeToModels[$model->code] = $model;
        }
        if (!empty($codeToModels[$code]->children))
        {
            return $codeToModels[$code]->children;
        }
        return array();
    }
	
	private function getClassModels()
	{
		$business = new NetTuanBusiness();
		$models = $business->getAllClassModels();
		return $models;
	}
	
	private function getCity()
	{
		$business = new NetTuanBusiness();
		$sityModels = $business->getCity();
		return $sityModels;
	}
	
	private function getCityRegion($currentCityCode)
	{
		$business = new NetTuanBusiness();
		$cityRegionModels = $business->getCityRegion($currentCityCode);
		return $cityRegionModels;
	}
    
	private function getCityName($code)
	{
		$business = new NetTuanBusiness();
		$cityModel = $business->getCityById($code);
        $name = null;
        if ($cityModel)
        {
            $name = $cityModel->name_cn;
        }
		return $name;
	}
	
	private function getAdModels()
	{
		$business = new HomeBrandAdBusiness();
		$adModels = $business->getHomeBrandAdModels(array(HomeBrandAdDataModel::STYPE_POSITION_TUAN_BOTTOM));
		return $adModels;
	}
}