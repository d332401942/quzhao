<?php 

class IndexBrandView extends BaseView
{
	
	public function index()
	{
		$this->setMeta();
		$business = new HomeBrandBusiness();
		$start = 0;
		$end = 16;
		$more = 16;
		$models = $business->getIndexBrandData($start, $end);
		$models = $models ? $models : array();
		
		//得到热门品牌
		$hotHomeBrandModels = $business->getHotHomeBrandModels();
		//得到品牌特卖处的广告
		$homeBrandAdBusiness = new HomeBrandAdBusiness();
		$adModels = $homeBrandAdBusiness->getHomeBrandAdModels(array(HomeBrandAdDataModel::STYPE_POSITION_BRAND_RIGHT_TOP));
		$this->assign('models', $models);
		$this->assign('adModels', $adModels);
		$this->assign('hotHomeBrandModels', $hotHomeBrandModels);
		$this->assign('start', $start);
		$this->assign('end', $end);
		$this->assign('more', $more);
	}
}