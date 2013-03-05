<?php 

class NetDataBusiness extends BaseBusiness
{
	
	public function findAll($pageCore,$homeTjClassIdArr = array())
	{
		
		$data = new NetDataData();
		$data->setPage($pageCore);
		$data->setOrder(array('ctime' => 'desc'));
		$query = array();
		$query['state'] = 1;
		
		
		if ($homeTjClassIdArr)
		{
			$query['home_tj_class_id'] = array('in' => $homeTjClassIdArr);
		}
		$data->where($query);
		$result = $data->findAll();
		return $result;
	}
	
	public function setState($id,$state)
	{
		$data = new NetDataData();
		$data->setState($id,$state);
	}
	
	public function demo()
	{
		$data = new NetDataData();
		$models = $data->findAll();
		return $models;
	}
	
	public function demo1($id)
	{
		$data = new NetDataData();
		$sourceBusiness = new NetDataSourceBusiness();
		$netDataSiteBusiness = new NetDataSiteBusiness();
		$model = $data->getOneById($id);
		if (!$model)
		{
			return ;
		}
		
		$groupStr = $model->ext1;
		$groupArr = explode('/', $groupStr);
		$className = array_shift($groupArr);
		$sourceName = $model->class3;
		$siteName = $model->site;
		
		if (!$className || !$sourceName || !$siteName)
		{
			return false;
		}
		
		$sourceBusiness = new NetDataSourceBusiness();
		$sourceModel = $sourceBusiness->getByName($sourceName);
		
		$netDataSiteBusiness = new NetDataSiteBusiness();
		$siteModel = $netDataSiteBusiness->findByName($siteName);
		
		$homeTjClass = new HomeTjClassBusiness();
		$classModel = $homeTjClass->getByName($className);
		
		
		if (!$classModel)
		{
			$classModel = new HomeTjClassDataModel();
			$classModel->name = $className;
			$classModel->pid = 2;
			$classModel->sort = 0;
			$classModel->isuse = 0;
			$homeTjClass->add($classModel);
		}
		
		if (!$sourceModel)
		{
			$sourceModel = new NetDataSourceDataModel();
			$sourceModel->name = $sourceName;
			$sourceModel->isuse = 0;
			$sourceBusiness->add($sourceModel);
		}
		
		if (!$siteModel)
		{
			$siteModel = new NetDataSiteDataModel();
			$siteModel->name = $siteName;
			$siteModel->isuse = 0;
			$netDataSiteBusiness->add($siteModel);
		}
		$sql = 'update net_data set net_data_source_id = '. $sourceModel->id .',home_tj_class_id = '.$classModel->id.',net_data_site_id = '.$siteModel->id;
		if ($this->democheckHref($model->href))
		{
			$sql .= ',state = 0 ';
		}
		$sql .= ' where id = '.$model->id;
		echo $sql;
		$data->exec($sql);
		exit;
	}
	
	private function democheckHref($href)
	{
		$url = array(
					'http://www.6pm.com',
					'http://www.rei.com',
					'http://www.adorama.com',
					'http://www.amazon.com',
					'http://www.woot.com',
					'http://www.ashford.com',
					'http://www.bookdepository.co.uk',
					'http://www.campmor.com/',
					'http://www.carters.com/',
					'http://www.crazy8.com',
					'http://www.diapers.com',
					'http://www.drugstore.com',
					'http://www.forever21.cn',
					'http://api.viglink.com/',
					'http://www.jomashop.com',
					'http://www.philosophy.com',
					'http://www.toysrus.com/',
					'https://dev.windowsphone.com/en-us/join',
				);
		
		foreach ($url as $v)
		{
			$href = urldecode($href);
			if (strpos($href, $v) !== false)
			{
				return true;
			}
		}
		return false;
	}
	
	public function getOneById($id)
	{
		$data = new NetDataData();
		$model = $data->getOneById($id);
		return $model;
	}
}