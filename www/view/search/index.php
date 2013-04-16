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
		$attrModels = array();
		$categoryBusiness = M('CategoryBusiness');
		if (!empty($parameters['keyword']))
		{
			$keyword = trim($parameters['keyword']);
		}
		
		if (!empty($parameters['category']))
		{
			$category = (int)($parameters['category']);
			$attrModels = $categoryBusiness->getAttrModelsByCategoryId($category);
			if(!empty($attrModels))
			{
				foreach($attrModels as $val)
				{
					if (empty($val->info))
					{
						break;
					}
					$arr = explode('#',$val->info);
					foreach($arr as $v)
					{
						$val->extend[] = explode(':',$v);
					}
				}
			}	
			$attrModels = array_values($attrModels);
		}
		if (!empty($parameters['sort']))
		{
			$sort = $parameters['sort'];
		}
        $keyword = urldecode($keyword);
		$business = M('SearchBusiness');
		$productModels = $business->searchProduct($pageCore, $keyword , $category, $sort);
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
		$this->assign('attrModels',$attrModels);
	}
}
