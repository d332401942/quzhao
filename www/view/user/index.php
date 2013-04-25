<?php

class IndexUserView extends BaseView
{

	public function index($parameters)
	{
		$this->setMeta ();
		$this->mustLogin ();
		
		$pageCore = new PageCoreLib ();
		$pageCore->pageSize = 12;
		$pageCore->currentPage = ! empty ( $parameters ['page'] ) ? ( int ) $parameters ['page'] : 1;
		$business = M ( 'HomeTjDataBusiness' );
		$result = $business->getUserLove ( $pageCore, $this->CurrentUser->id );
		$this->shareNumber ($parameters);
		//得到推荐的单品
		$business = new HomeTjDataBusiness();
		$tjModels = $business->getTjDpModels(3);
		$this->assign('tjModels', $tjModels);
		$this->assign ( 'pageCore', $pageCore );
		$this->assign ( 'model', $result );
	}

	private function shareNumber($parameters)
	{
		$pageCore = new PageCoreLib ();
		$pageCore->pageSize = 12;
		$pageCore->currentPage = ! empty ( $parameters ['page'] ) ? ( int ) $parameters ['page'] : 1;
		$business = M ( 'ShareBusiness' );
		$rows = $business->getShare ( $pageCore, $this->CurrentUser->id );
		$this->assign ( 'pageShareCore', $pageCore );
		$this->assign ( 'shareModel', $rows );
	}

}
?>