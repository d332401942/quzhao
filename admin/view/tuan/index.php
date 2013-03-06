<?php 

class IndexTuanView extends BaseView
{
	private $classModels;
    private $pageCore;
    
    public function index()
	{
        $this->pageCore = new PageCoreLib();
        $this->pageCore->currentPage = !empty($_GET['page']) ? (int)$_GET['page'] : 1;
		$this->assign('title','团购');
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
		$models = $this->getModels();
        $models = $models ? $models : array();
        $this->assign('models', $models);
		$this->assign('hotCityModels',$hotCityModels);
		$this->assign('headToModels',$headToModels);
		$this->assign('cityHead',$cityHead);
		$this->assign('pageCore',$this->pageCore);
		$this->assign('classModels',$this->classModels);
	}
	
    private function getModels()
    {
        $models = array();
        $city = !empty($_GET['city']) ? $_GET['city'] : null;
        $region = !empty($_GET['region']) ? $_GET['region'] : null;
        $class1 = !empty($_GET['class1']) ? $_GET['class1'] : null;
        $class2 = !empty($_GET['class2']) ? $_GET['class2'] : null;
        $sortStr = !empty($_GET['sort']) ? $_GET['sort'] : null;
        $keyword = !empty($_GET['keyword']) ? $_GET['keyword'] : null;
        $sort = array();
		switch ($sortStr)
		{
			case 'bought':
				$sort['bought'] = 'desc';
				$sort['sort'] = 'desc';
				break;
			case 'cur_price':
				$sort['cur_price'] = 'asc';
				$sort['sort'] = 'desc';
				break;
			case 'id':
				$sort['id'] = 'desc';
				$sort['sort'] = 'desc';
				break;
            default :
				$sort['sort'] = 'desc';
				break;
		}
		$sort['id'] = 'desc';
		//根据当前城市获取城市地区
		$regionModels = $this->getCityRegion($city);
        //得到小类
        $classModels2 = $this->getClassModels2($class1);
        
        $business = new NetTuanBusiness();
        $models = $business->getTuanModels($this->pageCore,$city,$region,$class1,$class2,$sort,$keyword);
        $this->assign('classModels2', $classModels2);
        $this->assign('regionModels', $regionModels);
        $this->assign('city', $city);
        $this->assign('region', $region);
        $this->assign('keyword', $keyword);
        $this->assign('class1', $class1);
        $this->assign('class2', $class2);
        $this->assign('sortStr', $sortStr);
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
        $cityRegionModels = null;
        if ($currentCityCode)
        {
            $business = new NetTuanBusiness();
            $cityRegionModels = $business->getCityRegion($currentCityCode);
        }
        $cityRegionModels = $cityRegionModels ? $cityRegionModels : array();
		return $cityRegionModels;
	}
}
