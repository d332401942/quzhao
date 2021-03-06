<?php 

class IndexContentView extends BaseView
{
	
	public function index($parameters)
	{
		$business = new HomeTjDataBusiness();
		$classBusiness = new HomeTjClassBusiness();
		$classModels = $classBusiness->findAll(array(HomeTjClassDataModel::IS_USE_TYPE_YES));
		//查询出所有来源网站
		$sourceBusiness = new NetDataSourceBusiness();
		$result = $sourceBusiness->findAll(array(NetDataSourceDataModel::IS_USE_YES));
		$sourceModels = array();
		if ($result)
		{
			foreach ($result as $model)
			{
				$sourceModels[$model->id] = $model;
			}
		}
		//查询出所有抓取网站
		$netDataSiteBusiness = new NetDataSiteBusiness();
		$result = $netDataSiteBusiness->findAll(array(NetDataSourceDataModel::IS_USE_YES));
		$siteModels = array();
		if ($result)
		{
			foreach ($result as $model)
			{
				$siteModels[$model->id] = $model;
			}
		}
		
		
		$idToClassModelList = array();
		foreach ($classModels as $model)
		{
			$model->SearchId = $model->id;
			foreach ($model->children as $k => $m)
			{
				$idToClassModelList[$m->id] = $m;
				$model->SearchId .= ','. $m->id;
			}
			$idToClassModelList[$model->id] = $model;
		}
		$pageCore = new PageCoreLib();
		$pageCore->pageSize = 10;
		
		
		$page = 1;
		if (!empty($_GET['page']) && (int)$_GET['page'] > 0)
		{
			$page = (int)$_GET['page'];
		}
		if (!empty($parameters['page']) && (int)$parameters['page'] > 0 )
		{
			$page = (int)$parameters['page'];
		}
		$state = array();
		if (isset($_GET['state']) && $_GET['state'] != null)
		{
			$state = explode(',',$_GET['state']);
		}
		$cid = array();
		$cidStr = '';
		if (!empty($_GET['cid']) && (int)$_GET['cid'])
		{
			$cidStr = $_GET['cid'];
			$cid = explode(',',$cidStr);
			
		}else if (!isset($_GET['cid']))
		{
			if($parameters)
			{
				$cid = isset($parameters['cid'])?intval($parameters['cid']):'';
				$cid = array($cid);
			}
		}
		$fid = null;
		if (!empty($_GET['fid']) && (int)$_GET['fid'])
		{
			$fid = (int)$_GET['fid'];
		}
		
		$site = null;
		if (!empty($_GET['site']) && (int)$_GET['site'])
		{
			$site = (int)$_GET['site'];
		}
		
        $istj = null;
        if (isset($_GET['istj']) && $_GET['istj'] !== '')
        {
            $istj = (int)$_GET['istj'];
        }
        
        $ishot = null;
        if (isset($_GET['ishot']) && $_GET['ishot'] !== '')
        {
            $ishot = (int)$_GET['ishot'];
        }

		$id = null;
		if (!empty($_GET['id']))
		{
			$id = $_GET['id'];
			$this->assign('id', $id);
		}
		$tempType = null;
		if (!empty($_GET['temp']))
		{
			$tempType = $_GET['temp'];
		}
		$pageCore->currentPage = $page;
		if ($id)
		{
			$models = $business->getOneById($id);
			
		}
		else
		{
			$models = $business->findAll($pageCore,$cid,$state,$fid,$site,$istj,$ishot,$tempType);
		}
		$models = $models ?  $models : array();
		foreach ($models as $model)
		{
			$model->jtClassName = '未知';
			if (isset($idToClassModelList[$model->cid]->name))
			{
				$model->jtClassName = $idToClassModelList[$model->cid]->name;
			}
			$model->SoureName = '未知';
			if ($model->fid == HomeTjDataDataModel::FID_HAND_INPUT)
			{
				$model->SoureName = '录入';
			}
			else if (isset($sourceModels[$model->fid]->name))
			{
				$model->SoureName = $sourceModels[$model->fid]->name;
			}
			$model->SiteName = '未知';
			if (isset($siteModels[$model->site]->name))
			{
				$model->SiteName = $siteModels[$model->site]->name;
			}
		}
		$this->assign('id', $id);
		$this->assign('page',$page);
		$this->assign('state',implode(',',$state));
		$this->assign('cid',$cidStr);
		$this->assign('fid',$fid);
		$this->assign('site',$site);
		$this->assign('istj',$istj);
		$this->assign('ishot',$ishot);
		$this->assign('models',$models);
		$this->assign('classModels',$classModels);
		$this->assign('sourceModels',$sourceModels);
		$this->assign('siteModels',$siteModels);
		$this->assign('title', '内容管理');
		$this->assign('pageCore', $pageCore);
		$this->assign('tempType', $tempType);
	}
}
