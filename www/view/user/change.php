<?php
class ChangeUserView extends BaseView
{
	public function index()
	{
		if($_POST)
		{
			$this->change();
		}
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
		if ($this->CurrentUser->city)
		{
			$city = $this->CurrentUser->city;
		}
		//得到城市名称
        $cityName = $this->getCityName($city);
		//默认字母
		$headLetter = 'L';
		//得到推荐的单品
		$business = new HomeTjDataBusiness();
		$tjModels = $business->getTjDpModels(2);
		$this->assign('tjModels', $tjModels);
		$this->assign('headLetter',$headLetter);
		$this->assign('cityName', $cityName);
		$this->assign('hotCityModels',$hotCityModels);
		$this->assign('headToModels',$headToModels);
		$this->assign('cityHead',$cityHead);
	}	
	
	private function change()
	{
		$business = M('UserBusiness');
		$model = $this->CurrentUser;
		$model->id 			= $this->CurrentUser->id;
		$model->head 		= '';
		$model->nickname 	= trim($_POST['nickname']);
		$model->city 		= intval($_POST['cityid']);
		$model->setWorkFields(array('head', 'nickname', 'city'));
		$business->changeData($model);
		//把用户信息记入cookie
		setcookie(BaseView::USER_INFO_COOKIE_KEY, json_encode($model), 0, '/');
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