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
		if (isset($parameters['category']))
		{
			$category = (int)($parameters['category']);
		}
		$sort = null;
		$priceStart = null;
		$priceEnd = null;
		if (!empty($parameters['attr_price']))
		{
			$arr = substr($parameters['attr_price'], 2);
			$arr = explode('-', $arr);
			$priceEnd = $arr[1];
			$priceStart = $arr[0];
			if ($priceEnd)
			{
				$priceStart = (int)$arr[0];
			}
		}
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
		
		if (!empty($parameters['sort']))
		{
			$sort = $parameters['sort'];
			if ($sort == 'price1')
			{
				$sortPrice = 'price2';
			}
		}
		$keyword = urldecode($keyword);
		$business = M('SearchBusiness');
		$mapCategorys = $category;
		
		/*if ($keyword && empty($category))
		{
			$mapCategorys = $this->getMapCategorys($keyword);
			$mapCategorys = explode(',',$mapCategorys->categoryids);
		}*/
		//记录搜索日志
		$ip = $_SERVER ['REMOTE_ADDR'];
		$business->logKeywords($keyword, $ip);
		//得到都有的品牌ID
		$brandIdToCount = $business->searchBrandIdToCount($keyword , $mapCategorys, $attrArr, $sort);
		$brandIds = array_keys($brandIdToCount);
		$searchBrandModels = $categoryBusiness->getSearchBrandDataModel($brandIds);
		foreach ($searchBrandModels as $model)
		{
			if (!empty($brandIdToCount[$model->brandid]))
			{
				$model->num = $brandIdToCount[$model->brandid];
			}
		}
		if ($category)
		{
			$attrModels = $categoryBusiness->getAttrModelsByCategoryId($category);
			if(!empty($attrModels))
			{
				foreach($attrModels as $key => $val)
				{
					if (empty($val->info))
					{
						break;
					}
					$arr = explode('#',$val->info);
					foreach($arr as $v)
					{
						$arr = explode(':',$v);
						
						if (!empty($arr[1]))
						{
							$arr[1] = str_replace(',', '-', $arr[1]);
						}
						$val->extend[] = $arr;
					}
				}
			}
			if(!empty($attrModels))
			{	
				$attrModels = array_values($attrModels);
			}
		}
		
		
		//得到历史记录
		$searchBrowseHistoryModels = $this->searchBrowseHistoryModels();
        //如果没有选择分类则去查询关键字对应到的分类
		$productModels = $business->searchProduct($pageCore, $keyword , $mapCategorys, $attrArr, $sort);
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
		$this->assign('priceEnd', $priceEnd);
		$this->assign('priceStart', $priceStart);
		$this->assign('searchBrandModels', $searchBrandModels);
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
	
	/**
	 *	查询关键词是否有对应的分类
	 */
	private function getMapCategorys($keyword)
	{
		$business = M('AssociatedBusiness');
		return $business->getOneCate($keyword);
	}
}
