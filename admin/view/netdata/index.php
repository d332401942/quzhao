<?php

class IndexNetdataView extends BaseView
{
	
	public function index()
	{
		$pageCore = new PageCoreLib();
		$pageCore->pageSize = 10;
		
		//得到分类
		$homeTjClassBusiness = new HomeTjClassBusiness();
		
		$classModels = $homeTjClassBusiness->findAll();
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
		$homeTjClassId = null;
		$homeTjClassIdArr = array();
		if (!empty($_GET['cid']))
		{
			$homeTjClassId = $_GET['cid'];
			$homeTjClassIdArr = explode(',',$homeTjClassId);
		}
		
		$page = 1;
		if (!empty($_GET['page']) && (int)$_GET['page'])
		{
			$page = (int)$_GET['page'];
		}
		$pageCore->currentPage = $page;
		$business = new NetDataBusiness();
		$models = $business->findAll($pageCore,$homeTjClassIdArr);
		$models = $models ? $models : array();
		$jtClassBusiness = new HomeTjClassBusiness();
		$rootClassModels = $jtClassBusiness->getRootClass();
		$rootModels = array();
		foreach ($rootClassModels as $model)
		{
			$rootModels[$model->id] = $model;
		}
		foreach ($models as $model)
		{
			if (isset($idToClassModelList[$model->home_tj_class_id]->name))
			{
				$model->ClassName = $idToClassModelList[$model->home_tj_class_id]->name;
			}
		}
		$this->assign('title','备选库'); 
		$this->assign('pageCore',$pageCore);
		$this->assign('classModels',$classModels);
		$this->assign('homeTjClassId',$homeTjClassId);
		$this->assign('rootModels',$rootModels);
		$this->assign('models',$models);
	}
}