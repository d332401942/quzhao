<?php 

class IndexSearchView extends BaseView
{
	
	public function index($parameters)
	{
		$this->setMeta();
		$nineModels = array();
		$dpModels = array();
		$pageCore = new PageCoreLib();
        $pageCore->currentPage = !empty($parameters['page']) ? (int)$parameters['page'] : 1;
		$pageCore->currentPage = $pageCore->currentPage ? $pageCore->currentPage : 1;
		$keyword = null;
		if (!empty($parameters['keyword']))
		{
			$keyword = trim($parameters['keyword']);
		}
        $keyword = urldecode($keyword);
		$business = M('SearchBusiness');
		$models = $business->search($pageCore, $keyword);
		
		//todo
		$this->assign('pageCore',$pageCore);
		$keyword = htmlspecialchars($keyword);
        $this->assign('keyword', $keyword);
	}
}
