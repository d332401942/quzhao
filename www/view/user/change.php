<?php
class ChangeUserView extends BaseView
{
	public function index()
	{
		$this->setMeta();
		$this->mustLogin();
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
		
		//TODO 默认为北京以后根据IP判断
		$cityCommon = new CityCommon();
		$city = $cityCommon->getCurrentCityId();
		if (!$city) 
		{
			$city = 10100;
		}
		//得到城市名称
        $cityName = $this->getCityName($city);
		//默认字母
		$headLetter = 'L';
		if($_POST)
		{
			$this->change();
		}
		$this->assign('headLetter',$headLetter);
		$this->assign('cityName', $cityName);
		$this->assign('hotCityModels',$hotCityModels);
		$this->assign('headToModels',$headToModels);
		$this->assign('cityHead',$cityHead);
	}	
	
	private function change()
	{
		$business = M('UserBusiness');
		$model = new UserDataModel();
		$model->id 			= $this->CurrentUser->id;
		$model->head 		= '';
		$model->nickname 	= trim($_POST['nickname']);
		$model->city 		= intval($_POST['cityid']);
		$model->setWorkFields(array('head', 'nickname', 'city'));
		$business->changeData($model);
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
	
	private function getCity()
	{
		$business = new NetTuanBusiness();
		$sityModels = $business->getCity();
		return $sityModels;
	}
}
?>