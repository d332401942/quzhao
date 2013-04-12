<?php

class SearchData extends BaseData
{

	public function __construct()
	{

	}

	public function searchProduct($pageCore, $keyword)
	{
		$productIds = $this->getProductIds($pageCore, $keyword);
		//查询分组
		$categoryIdToCount = $this->getCategoryIdToCount($keyword);

		//通过ID查询出来结果
		$productData = M('ProductData');
		$fileds = array();
		$productModels = $productData->searchProductByIds($productIds, $keyword, $fileds);
		$this->setLight($productModels, $keyword);
		return $productModels;
	}

	public function getCategoryIdToCount($keyword)
	{
		$sphinx = M('SphinxDbLib');
		$sphinx->setGroupBy('categoryid', SPH_GROUPBY_ATTR, '@count desc');
		$result = $sphinx->query($keyword, 'product');
		$sphinx->clear();
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

	public function getProductIds($pageCore, $keyword)
	{
		$start = ($pageCore->currentPage - 1) * $pageCore->pageSize;
		$sphinx = M('SphinxDbLib');
		$sphinx->setLimits($start, $pageCore->pageSize, 1000000);
		$this->setWeights();
		$this->setSortMode();
		$result = $sphinx->query($keyword, 'product');
		$productIds = $sphinx->getResultIds($result, $pageCore);
		$sphinx->clear();
		return $productIds;
	}

	private function setLight($productModels, $keyword)
	{
		$sphinx = M('SphinxDbLib');
		$needLightFileds = array(
			'title',
		);
		$opts = array(
			'before_match' => '<strong>',
			'after_match' => '</strong>',
		);
		foreach ($productModels as $key => $model)
		{
			$docs = array();
			foreach ($needLightFileds as $key => $val)
			{
				$docs[$key] = CommUtilLib::truncate($model->$val, 25);
			}
			$arr = $sphinx->buildExcerpts($docs, 'product', $keyword, $opts);
			foreach ($needLightFileds as $key => $val)
			{
				$field = 'light' . $val;
				$model->$field = $arr[$key];
			}
		}
	}

	private function setWeights()
	{
		$sphinx = M('SphinxDbLib');
		$weights = array(
			'name' => 100,
			'brandname' => 50,
			'info' => 20,
		);
		$sphinx->setFieldWeights($weights);
	}

	private function setSortMode()
	{
		$sphinx = M('SphinxDbLib');
		$sphinx->setSortMode(SPH_SORT_EXTENDED, '@weight desc');
	}
}
