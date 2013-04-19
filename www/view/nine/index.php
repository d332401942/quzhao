<?php 

class IndexNineView extends BaseView
{
	
	public function index($parameters)
	{
		$this->setMeta();
		//得到9.9的数据 
		$pageCore = new PageCoreLib();
		$business = new HomeTjDataBusiness();
		$states = array(
				HomeTjDataDataModel::STATE_EMPTY,
				HomeTjDataDataModel::STATE_HAVE,
				);
		$pageCore->pageSize = 21;
		$pageCore->currentPage = !empty($parameters['page']) ? $parameters['page'] : 1;
		$models = $business->findAll($pageCore, array(1), $states);
		$this->assign('models',$models);
		$this->assign('pageCore',$pageCore);
	}
}