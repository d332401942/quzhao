<?php 

class IndexSearchView extends BaseView
{
	
	public function index($parameters)
	{
		$this->setMeta();
		$nineModels = array();
		$dpModels = array();
		$pageCore = new PageCoreLib();
		$pageCore->pageSize = 20;
        $pageCore->currentPage = !empty($parameters['page']) ? (int)$parameters['page'] : 1;
		$pageCore->currentPage = $pageCore->currentPage ? $pageCore->currentPage : 1;
		$keyword = null;
		$category = null;
		$sort = null;
		$sortPrice = 'price1';
		$showType = null;
		$attrArr = $this->getAttrArr($parameters);
		$attrModels = array();
		$categoryBusiness = M('CategoryBusiness');
		
		if (!empty($parameters['keyword']))
		{
			$keyword = trim($parameters['keyword']);
		}
		
		if (!empty($parameters['showtype']))
		{
			$showType = trim($parameters['showtype']);
			$showType = strtolower($showType);
			if ($showType != 'list')
			{
				$showType = 'detail';
			}
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
						if (!empty($val->extend[1]))
						{
							$val->extend[1] = str_replace(',', '-', $val->extend[1]);
						}
					}
				}
			}	
			if(!empty($attrModels))
			{	
				$attrModels = array_values($attrModels);
			}
		}
		
		if (!empty($parameters['sort']))
		{
			$sort = $parameters['sort'];
			if ($sort == 'price1')
			{
				$sortPrice = 'price2';
			}
		}
		//得到历史记录
		$searchBrowseHistoryModels = $this->searchBrowseHistoryModels();
        $keyword = urldecode($keyword);
		$business = M('SearchBusiness');
		$productModels = $business->searchProduct($pageCore, $keyword , $category, $attrArr, $sort);
		//TODO 得到特别推荐
		$recommendModels = $business->getRecommendModels($keyword);
		$recommendModels = array_values($recommendModels);

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
        $this->assign('sortPrice', $sortPrice);
        $this->assign('showType', $showType);
		$this->assign('attrModels',$attrModels);
		$this->assign('attrArr',$attrArr);
		$this->assign('searchBrowseHistoryModels', $searchBrowseHistoryModels);
		$this->assign('recommendModels', $recommendModels);
	}

	private function getAttrArr($parameters)
	{
		$attrArr = array();
		foreach ($parameters as $key => $val)
		{
			if (strpos($key, 'attr_') === 0)
			{
				$attrArr[substr($key, 5)] = $val;
			}
		}
		return $attrArr;
	}
	private function searchBrowseHistoryModels()
	{
		if (empty($_COOKIE['searchBrowseLog']))
		{
			return array();
		}
		$ids = $_COOKIE['searchBrowseLog'];
		$arrIds = explode(',',$ids);
		$business = new SearchBusiness();
		$models = $business->searchBrowseHistoryModels($arrIds);
		$models = $models ? $models : array();
		return $models;
	}
}
