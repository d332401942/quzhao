<?php 

class Index2IndexView extends BaseView
{
	
	private $classModels = array();
	
    
	public function index()
	{
		//得到当前城市的城市code
		$cityCommon = new CityCommon();
		$cityCode = $cityCommon->getCurrentCityId();
		//得到单品的分类数据
		$homeClassBusiness = new HomeTjClassBusiness();
		$classModels = $homeClassBusiness->findAll();
		if ($classModels)
		{
			$this->classModels = $classModels;
		}
		$homeTjDataModels = $this->nineModel();
		$cids = array(2);
		foreach ($classModels[1]->children as $model)
		{
			$cids[] = $model->id;
		}
		$dpModels = $this->getDpModels();
 		$hotHomeBrandModels = $this->getHotHomeBrandModels();
 		//得到首页品牌特卖的数据
 		$brandDataModels = $this->getIndexBrandDataModels();
 		//得到热门商家数据
        $this->cache('getHomeBsModels');
 		//得到首页超值单品处广告
 		$bomeBrandAdModels = $this->getHomeBrandAdModels();
        //得到首页团购数据
        $tuanBusiness = new NetTuanBusiness();
        $tuanModels = $tuanBusiness->getIndexTuanModels();
        $tuanModels = $tuanModels ? $tuanModels : array();
		
		
		//得到所有品牌数据
		$num = 1;
		$business = M('BrandBusiness');
		$result = $business->getAll2('','','','',$num);
		$this->assign('brandModel' ,$result);
		
		
		$this->assign('dpModels', $dpModels);
		$this->assign('hotHomeBrandModels', $hotHomeBrandModels);
		
		$this->assign('bomeBrandAdModels', $bomeBrandAdModels);
		$this->assign('brandDataModels', $brandDataModels);
		$this->assign('homeTjDataModels',$homeTjDataModels);
		$this->assign('tuanModels',$tuanModels);
		
		$this->setMeta();
        //$this->display();
	}
	
	/**
	 * 得到首页9.9包邮的数据
	 */
	private function nineModel()
	{
		$business = new HomeTjDataBusiness();
		$homeTjDataModels = $business->nineModel();
		return $homeTjDataModels;
	}
	
	private function getDpModels()
	{
		$business = new HomeTjDataBusiness();
		$dpModels = $business->getDpModels();
		return $dpModels;
	}
	
	/**
	 * 得到热门品牌数据
	 */
	private function getHotHomeBrandModels()
	{
		$business = new HomeBrandBusiness();
		return $business->getHotHomeBrandModels();
	}
	
	private function getIndexBrandDataModels()
	{
		$business = new HomeBrandBusiness();
		return $business->getIndexBrandDataModels();
	}
	
	/**
	 * 得到热门商家数据
	 */
	public function getHomeBsModels()
	{
		$business = new HomeBsDataBusiness();
		$models = $business->getHomeBsModels();
        $this->assign('homeBsModels', $models);
	}
	
	/**
	 * 得到首页超值单品处的广告
	 * @return Ambigous <boolean, unknown>
	 */
	private function getHomeBrandAdModels()
	{
		$business = new HomeBrandAdBusiness();
		return $business->getHomeBrandAdModels(array(HomeBrandAdDataModel::STYPE_POSITION_DB_INDEX));
	}
}
