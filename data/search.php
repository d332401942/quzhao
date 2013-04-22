<?php

class SearchData extends BaseData
{

	private $lightWords = array();

	public function __construct()
	{

	}

	public function searchProduct($pageCore, $keyword , $categoryIds = array(), $attrArr = array(), $sort = null)
	{
		$productIds = $this->getProductIds($pageCore, $keyword, $categoryIds,$attrArr, $sort);
		//通过ID查询出来结果
		$productData = M('ProductData');
		$fileds = array();
		$productModels = array();
		if ($productIds)
		{
			$productModels = $productData->searchProductByIds($productIds, $fileds);
		}
		$this->setLight($productModels);
		return $productModels;
	}

	public function getRecommendModels($keyword)
	{
		$sphinx = new SphinxDbLib();
		$productModels = array();
		$productData = M('ProductData');
		$this->setWeights($sphinx);
		$sort = '@weight desc';
		$this->setSortMode($sphinx, $sort);
		$this->setPublicFilter($sphinx);
		$sphinx->setLimits(0, 5, 5);
		$result = $sphinx->query($keyword, 'product');
		$productIds = $sphinx->getResultIds($result);
		if (empty($productIds))
		{
			return $productModels;
		}
		$productModels = $productData->searchProductByIds($productIds);
		return $productModels;
	}

	public function getCategoryIdToCount($keyword)
	{
		$sphinx = new SphinxDbLib();
		$sphinx->setGroupBy('categoryid', SPH_GROUPBY_ATTR, '@count desc');
		$this->setPublicFilter($sphinx);
		$result = $sphinx->query($keyword, 'product');
		
		$categoryIdToCount = array();
		if (!empty($result['matches']))
		{
			foreach ($result['matches'] as $arr)
			{
				if (!empty($arr['attrs']['categoryid']))
				{
					$id = $arr['attrs']['categoryid'];
					$count = $arr['attrs']['@count'];
					$categoryIdToCount[$id] = $count;
				}
			}
		}
		return $categoryIdToCount;
	}

	public function getProductIds($pageCore, $keyword, $categoryIds = array(),$attrArr = array(), $sort = null)
	{
		$start = ($pageCore->currentPage - 1) * $pageCore->pageSize;
		$sphinx = M('SphinxDbLib');
		$sphinx->setMatchMode(SPH_MATCH_EXTENDED2);
		$sphinx->setLimits($start, $pageCore->pageSize, $start + $pageCore->pageSize);
		$this->setWeights($sphinx);
		$this->setSortMode($sphinx, $sort);
		$this->setPublicFilter($sphinx);
		if ($categoryIds)
		{
			$sphinx->setFilter('categoryid', $categoryIds);
		}
		foreach ($attrArr as $key => $val)
		{
			$arr = explode('_', $val);
			if (count($arr) != 2) 
			{
				continue;
			}
			$type = $arr[0];
			$value = $arr[1];
			$array = explode('-', $value);
			switch ($type)
			{
				case 0:
					$sphinx->setFilter($key, $array);
					break;
				case 1:
					if (count($array) == 2)
					{
						$sphinx->setFilterRange($key, $array[0], $array[1]);
					}
					break;
				case 2:
					if (count($array) == 2)
					{
						$sphinx->setFilterFloatRange($key, $array[0], $array[1]);
					}
					break;
			}
		}
		$result = $sphinx->query($keyword, 'product');
		$lightWords = $sphinx->getLightWords($result);
		$this->lightWords = $sphinx->getLightWords($result);
		$productIds = $sphinx->getResultIds($result, $pageCore);
		$sphinx->clear();
		return $productIds;
	}

	private function setLight($productModels)
	{
		$sphinx = M('SphinxDbLib');
		$needLightFileds = array(
			'title',
		);
		$opts = array(
			'before_match' => '<strong>',
			'after_match' => '</strong>',
		);
		foreach ($productModels as $model)
		{
			$docs = array();
			foreach ($needLightFileds as $val)
			{
				$field = 'light' . $val;			
				$str = CommUtilLib::truncate($model->$val, 45);
				$model->$field = $this->replace($this->lightWords,$opts,$str);
			}
		}
	}
	
	private function replace($words,$opts,$str)
	{
		return $str;
		$words = array('小人物','小人','小');
		$str = 'sdf小张是一[@@]个小人[\@@]，他小弟是个小人物吗？12';
		foreach ($words as $v)
		{
			$i = mb_strpos($str, $v, 'utf-8');
			$l = mb_strlen($v);
			if ($i !== false)
			{
				$lastStr = mb_substr($str, $i + $l);
			}
		}
	}
	
	private function setWeights($sphinx)
	{
		$weights = array(
			'name' => 100,
			'brandname' => 50,
			'info' => 20,
		);
		$sphinx->setFieldWeights($weights);
	}

	private function setSortMode($sphinx, $sort)
	{
		$sortStr = '@weight desc';
		$sort = strtolower($sort);
		switch ($sort)
		{
			case 'sales':
				$sortStr = 'sales desc';
				break;
			case 'createtime':
				$sortStr = 'createtime desc';
				break;
			case 'price':
				$sortStr = 'price asc';
				break;
		}
		$sphinx->setSortMode(SPH_SORT_EXTENDED, $sortStr);
	}

	private function setPublicFilter($sphinx)
	{
		$sphinx->setFilter('isdelete', array(0));
	}
}
