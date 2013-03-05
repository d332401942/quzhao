<?php 

class SearchTuanView extends BaseView
{
	
	public function index()
	{
		$pageCore = new PageCoreLib();
		$pageCore->pageSize = 24;
		$pageCore->currentPage = empty($_POST['page']) ? 1 : (int)$_POST['page'];
		$pageCore->currentPage = !$pageCore->currentPage ? 1 : $pageCore->currentPage;
		$models = $this->getTuanModels($pageCore);
		$this->assign('models', $models);
		$this->assign('pageCore', $pageCore);
	}
	
	private function getTuanModels($pageCore)
	{
		$region = null;
		$class = null;
		$keyword = null;
		$class2 = null;
        $city = null;
		if (!empty($_POST['region']))
		{
			$region = $_POST['region'];
		}
		if (!empty($_POST['class']))
		{
			$class = $_POST['class'];
		}
		if (!empty($_POST['class2']))
		{
			$class2 = $_POST['class2'];
		}
        if (!empty($_POST['city']))
        {
            $city = $_POST['city'];
        }
		$business = new NetTuanBusiness();
		$sort = array();
		switch ($_POST['sort'])
		{
			case 'sort':
				$sort['sort'] = 'desc';
				break;
			case 'bought':
				$sort['bought'] = 'desc';
				break;
			case 'cur_price':
				$sort['cur_price'] = 'asc';
				break;
			case 'id':
				$sort['id'] = 'desc';
				break;
		}
		if (!empty($_POST['keyword']))
		{
			$keyword = trim($_POST['keyword']);
		}
		$models = $business->getTuanModels($pageCore,$city,$region,$class,$class2,$sort,$keyword);
		return $models;
	}
}