<?php 

class DplistsBrandadminView extends BaseView
{
	public function index($parameters)
	{
		if(empty($_COOKIE['brand_id']) && empty($_COOKIE['brandModel']) && empty($_COOKIE['brand_name']))
		{
			$this->redirect(APP_URL . '/brandadmin/login');
		}
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

		
		$pageCore->currentPage = $page;
		$tempType = 1;
		$userid = null;
		if(!empty($_COOKIE['brand_id']))
		{
			$userid = $_COOKIE['brand_id'];
		}	
		
		$models = $business->findAll($pageCore,$cid,$state,$fid,$site,$istj,$ishot,$tempType,$userid);
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
		//得到总数
		$count = $business->getAllTotal($tempType,$userid);
		//得到已经通过审核总数
		$tgCount = $business->tgCount($tempType,$userid);
		$this->assign('models',$models);
		$this->assign('count',$count);
		$this->assign('tgCount',$tgCount);
		$this->assign('pageCore', $pageCore);
	}

}