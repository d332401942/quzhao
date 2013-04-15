<?php 

class IndexSearchView extends BaseView
{
	
	public function index($parameters)
	{
		$this->setMeta();
		$nineModels = array();
		$dpModels = array();
		$pageCore = new PageCoreLib();
		$pageCore->pageSize = 18;
        $pageCore->currentPage = !empty($parameters['page']) ? (int)$parameters['page'] : 1;
		$pageCore->currentPage = $pageCore->currentPage ? $pageCore->currentPage : 1;
		$keyword = null;
		$category = null;
		$sort = null;
		$categoryBusiness = M('CategoryBusiness');
		if (!empty($parameters['keyword']))
		{
			$keyword = trim($parameters['keyword']);
		}
		if (!empty($parameters['category']))
		{
			$category = (int)($parameters['category']);
			$attrModels = $categoryBusiness->getAttrModelsByCategoryId($category);
			//P($attrModels);
		}
		if (!empty($parameters['sort']))
		{
			$sort = $parameters['sort'];
		}
        $keyword = urldecode($keyword);
		$business = M('SearchBusiness');
		$categoryBusiness = M('CategoryBusiness');
		$productModels = $business->searchProduct($pageCore, $keyword , $category, $sort);
		$attrModels = $categoryBusiness->getAttrModelsByCategoryId($category);
		$categoryModels = $categoryBusiness->search($keyword);
		$productModels = array_values($productModels);
		$hostCategoryModels = array_shift($categoryModels);
		$this->assign('categoryModels', $categoryModels);
		$this->assign('hostCategoryModels', $hostCategoryModels);
		$this->assign('productModels', $productModels);
		$this->assign('pageCore',$pageCore);
		$keyword = htmlspecialchars($keyword);
        $this->assign('keyword', $keyword);
        $this->assign('category', $category);
        $this->assign('sort', $sort);
	}
}
