<?php
class IndexUserView extends BaseView
{
	public function index($parameters)
	{
		$this->setMeta();	
		$this->mustLogin();
		$pageCore = new PageCoreLib();
		$pageCore->pageSize = 12;
		$pageCore->currentPage = !empty($parameters['page']) ? (int)$parameters['page'] : 1;
		$business = M('HomeTjDataBusiness');
		$result = $business->getUserLove($pageCore,$this->CurrentUser->id);	
		$this->shareNumber();
		$this->assign('pageCore',$pageCore);	
		$this->assign('model',$result);	
	}
	
	private function shareNumber()
	{	$pageCore = new PageCoreLib();
		$pageCore->pageSize = 12;
		$pageCore->currentPage = !empty($parameters['page']) ? (int)$parameters['page'] : 1;
		$business = M('ShareBusiness');
		$rows = $business->getShareTotal($pageCore,$this->CurrentUser->id);	
		$this->assign('pageShareCore',$pageCore);	
		$this->assign('shareModel',$rows);
	}
}
?>