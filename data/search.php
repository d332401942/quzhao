<?php

class SearchData extends BaseData
{

	private $lightWords = array ();

	public function __construct()
	{
	}
	
	public function searchProduct($pageCore, $keyword, $categoryIds = array(), $attrArr = array(), $sort = null)
	{
		
		//生成memcache键值
		$cateDb = null;
		if(!empty($categoryIds))
		{
			$cateDb = implode(',',$categoryIds);
		}
		$attrDb = null;
		if(!empty($attrArr))
		{
			$attrDb = implode(',',$attrArr);
		}
		$key = md5($pageCore->currentPage.$keyword.$cateDb.$attrDb);
		
		//查询memcache
		$dataId = $this->getSearchCache($key);
		if(!empty($dataId))
		{
			$model = $this->getAllId($dataId);
			return $model;
		}
		
		$productIds = $this->getProductIds ( $pageCore, $keyword, $categoryIds, $attrArr, $sort );
		// 通过ID查询出来结果
		$productData = M ( 'ProductData' );
		$fileds = array ();
		$productModels = array ();
		if ($productIds)
		{
			$productModels = $productData->searchProductByIds ( $productIds, $fileds );
		}
		$this->setLight ( $productModels );
	
		$memcache = M('MemcacheDbLib');
		$result = array();
		foreach($productModels as $val)
		{
			$result[] = $val->productid;
		}
		$data = json_encode($result);
		$memcache->set($key, $data, 0, 3600);
		return $productModels;
	}
	
	/**
	 *	memcache得到搜索条件
	 */
	 private function getSearchCache($key)
	 {
		$memcache = M('MemcacheDbLib');
		$data = $memcache->get($key);
		return $data;
	 }
	 
	/**
	 *	通过ID查询产品
	 */
	private function getAllId($ids)
	{
		$this->selectSearchSlaveDb();
		$ids = implode(',',$ids);
		$sql = 'select * from product where productid in('.$ids.')';
		$data = $this->query($sql,'ProductDataModel');
		return $data;
	}
	/**
	 * 搜索关键字都有的分类和数木
	 *
	 * @param string $keyword        	
	 * @param id $category
	 *        	类别ID
	 * @param array $attrArr
	 *        	商品属性
	 * @return unknown
	 */
	public function searchBrandIdToCount($keyword, $category, $attrArr)
	{
		if (! $category)
		{
			$categorys = array ();
		}
		else if (! is_array ( $category ))
		{
			$categorys = array (
							$category 
			);
		}
		else
		{
			$categorys = $category;
		}
		if (isset ( $attrArr ['brandid'] ))
		{
			unset ( $attrArr ['brandid'] );
		}
		$sphinx = new SphinxDbLib ();
		$this->setPublicFilter ( $sphinx );
		$sphinx->SetFilter ( 'brandid', array (
						0 
		), true );
		$sphinx->setGroupBy ( 'brandid', SPH_GROUPBY_ATTR, '@count desc' );
		if ($categorys)
		{
			$sphinx->setFilter ( 'categoryid', $categorys );
		}
		$this->setAttr ( $sphinx, $attrArr );
		$result = $sphinx->query ( '@title ' . $keyword, 'product' );
		$brandIdToCount = array ();
		if (! empty ( $result ['matches'] ))
		{
			foreach ( $result ['matches'] as $arr )
			{
				if (! empty ( $arr ['attrs'] ['brandid'] ))
				{
					$id = $arr ['attrs'] ['brandid'];
					$count = $arr ['attrs'] ['@count'];
					$brandIdToCount [$id] = $count;
				}
			}
		}
		return $brandIdToCount;
	}

	public function logKeywords($keywords, $ip)
	{
		$keywordsModel = M ( 'KeywordsDataModel' );
		$keywordsModel->keywords = $keywords;
		$keywordsModel->createtime = time ();
		$keywordsModel->ip = ip2long ( $ip );
		$this->add ( $keywordsModel );
	}

	public function getRecommendModels($keyword)
	{
		$sphinx = new SphinxDbLib ();
		$productModels = array ();
		$productData = M ( 'ProductData' );
		$this->setWeights ( $sphinx );
		$sort = '@weight desc';
		$this->setSortMode ( $sphinx, $sort );
		$this->setPublicFilter ( $sphinx );
		$sphinx->setLimits ( 0, 5, 5 );
		$result = $sphinx->query ( $keyword, 'product' );
		$productIds = $sphinx->getResultIds ( $result );
		if (empty ( $productIds ))
		{
			return $productModels;
		}
		$productModels = $productData->searchProductByIds ( $productIds );
		return $productModels;
	}

	public function getCategoryIdToCount($keyword)
	{
		$sphinx = new SphinxDbLib ();
		
		$this->setWeights ( $sphinx );
		$this->setPublicFilter ( $sphinx );
		$sphinx->setGroupBy ( 'categoryid', SPH_GROUPBY_ATTR, '@count desc' );
		$result = $sphinx->query ( '@title ' . $keyword, 'product' );
		$categoryIdToCount = array ();
		if (! empty ( $result ['matches'] ))
		{
			foreach ( $result ['matches'] as $arr )
			{
				if (! empty ( $arr ['attrs'] ['categoryid'] ))
				{
					$id = $arr ['attrs'] ['categoryid'];
					$count = $arr ['attrs'] ['@count'];
					$categoryIdToCount [$id] = $count;
				}
			}
		}
		return $categoryIdToCount;
	}

	public function getProductIds($pageCore, $keyword, $categoryIds = array(), $attrArr = array(), $sort = null)
	{
		$start = ($pageCore->currentPage - 1) * $pageCore->pageSize;
		$sphinx = M ( 'SphinxDbLib' );
		$sphinx->setLimits ( $start, $pageCore->pageSize, $start + $pageCore->pageSize );
		$this->setWeights ( $sphinx );
		$this->setSortMode ( $sphinx, $sort );
		$this->setPublicFilter ( $sphinx );
		if ($categoryIds)
		{
			$sphinx->setFilter ( 'categoryid', $categoryIds );
		}
		$keyLast = '';
		if (! empty ( $attrArr ['brandid'] ))
		{
			$data = M ( 'CategoryData' );
			$id = explode ( '_', $attrArr ['brandid'] );
			$id = ( int ) $id [1];
			$categoryDataModel = $data->getSearchOneBrandDataModel ( $id );
			if (! empty ( $categoryDataModel->brandname ))
			{
				$keyLast = ' @(title,attrs) (' . $categoryDataModel->brandname . ')';
				
			}
			unset($attrArr ['brandid']);
		}
		$this->setAttr ( $sphinx, $attrArr );
		$result = $sphinx->query ( '@title ' . $keyword . $keyLast, 'product' );
		$lightWords = $sphinx->getLightWords ( $result );
		$this->lightWords = $sphinx->getLightWords ( $result );
		$productIds = $sphinx->getResultIds ( $result, $pageCore );
		$sphinx->clear ();
		return $productIds;
	}

	private function setAttr($sphinx, $attrArr)
	{
		foreach ( $attrArr as $key => $val )
		{
			$arr = explode ( '_', $val );
			if (count ( $arr ) != 2)
			{
				continue;
			}
			$type = $arr [0];
			$value = $arr [1];
			$array = explode ( '-', $value );
			switch ($type)
			{
				case 0 :
					$sphinx->setFilter ( $key, $array );
					break;
				case 1 :
					if (count ( $array ) == 2)
					{
						$sphinx->setFilterRange ( $key, $array [0], $array [1] );
					}
					break;
				case 2 :
					if (count ( $array ) == 2)
					{
						$start = floatval ( $array [0] );
						$end = floatval ( $array [1] );
						if (! $start && $end)
						{
							$start = 0.0;
						}
						if ($start && ! $end)
						{
							$end = floatval ( 999999999 );
						}
						if ($start > $end)
						{
							$sphinx->setFilterFloatRange ( $key, $end, $start );
						}
						else
						{
							$sphinx->setFilterFloatRange ( $key, $start, $end );
						}
					}
					break;
			}
		}
	}

	private function setLight($productModels)
	{
		$sphinx = M ( 'SphinxDbLib' );
		$needLightFileds = array (
						'title' 
		);
		$opts = array (
						'before_match' => '<strong>',
						'after_match' => '</strong>' 
		);
		foreach ( $productModels as $k => $model )
		{
			$docs = array ();
			foreach ( $needLightFileds as $val )
			{
				$field = 'light' . $val;
				$str = CommUtilLib::truncate ( $model->$val, 45 );
				$model->$field = $this->replace ( $this->lightWords, $opts, $str );
			}
		}
	}

	private function replace($words, $opts, $str)
	{
		return $str;
		$words = array (
						'小人物',
						'小人',
						'小' 
		);
		$str = 'sdf小张是一[@@]个小人[\@@]，他小弟是个小人物吗？12';
		foreach ( $words as $v )
		{
			$i = mb_strpos ( $str, $v, 'utf-8' );
			$l = mb_strlen ( $v );
			if ($i !== false)
			{
				$lastStr = mb_substr ( $str, $i + $l );
			}
		}
	}

	private function setWeights($sphinx)
	{
		$weights = array (
						'name' => 100,
						'brandname' => 50,
						'info' => 20 
		);
		$sphinx->setFieldWeights ( $weights );
	}

	private function setSortMode($sphinx, $sort)
	{
		$sortStr = 'weight desc, @weight desc';
		$sort = strtolower ( $sort );
		switch ($sort)
		{
			case 'sales' :
				$sortStr = ',sales desc';
				break;
			case 'createtime' :
				$sortStr = ',createtime desc';
				break;
			case 'price1' :
				$sortStr = ',price asc';
				break;
			case 'price2' :
				$sortStr = ',price desc';
				break;
		}
		$sphinx->setSortMode ( SPH_SORT_EXTENDED, $sortStr );
	}

	private function setPublicFilter($sphinx)
	{
		$sphinx->setFilter ( 'isdelete', array (
						0 
		) );
		$sphinx->setFilter ( 'siteid', array (
						111 
		), true );
	}

}
