<?php

class CategoryBusiness extends BaseBusiness
{

	public function search($keyword)
	{
		$searchData = M('SearchData');
		$categoryIdToCount = array();
		
		//如果关键词是一个分组则显示分组
		$categoryData = new CategoryData();
		$categoryIds = $categoryData->getCategoryIdsByName($keyword);
		if (!$categoryIds)
		{
			$categoryModels = array();
			$categoryIdToCount = $searchData->getCategoryIdToCount($keyword);
			if (empty($categoryIdToCount))
			{
				return $categoryIdToCount;
			}
			$categoryIds = array_keys($categoryIdToCount);
		}
		$categoryModels = $this->getCompleteCategoryByIds($categoryIds, $categoryIdToCount);
		return $categoryModels;
	}

	/**
	 * 通过分类ID获取他的上级已经下级的所有数据
	 */
	public function getCompleteCategoryByIds($ids, $categoryIdToCount = array())
	{
		$data = M('CategoryData');
		$models = $data->getCompleteCategoryByIds($ids, $categoryIdToCount);
		return $models;
	}
	
	public function getAttrModelsByCategoryId($categoryId)
	{
		$data = M('CategoryData');
		$attrModel = $data->getAttrId($categoryId);
		
		$result = array();
		if (empty($attrModel->attrid))
		{
			return $result;
		}
		$result = $data->getAttrDbs($attrModel->attrid);
		return $result;
	}
	
	/**
	 * 根据品牌ID获取品牌
	 * @param unknown $brandIds
	 * @return multitype:
	 */
	public function getSearchBrandDataModel($brandIds)
	{
		$searchBrandModels = array();
		if (!$brandIds)
		{
			return $searchBrandModels;
		}
		$data = new CategoryData();
		$searchBrandModels = $data->getSearchBrandDataModel($brandIds);
		if (!$searchBrandModels)
		{
			$searchBrandModels = array();
		}
		return $searchBrandModels;
	}
	
	/**
	 * 根据品牌ID获取一个品牌
	 * @param unknown $barndId
	 */
	public function getSearchOneBrandDataModel($barndId)
	{
		$data = M('CategoryData');
		return $data->getSearchOneBrandDataModel();
	}
	
	/*
	*	 得到所有分类
	*/
	public function getAll($pageCore,$lev)
	{
		$data = new CategoryData();
		return $data->getAll($pageCore,$lev);
	}
	
	/*
	*	 得到已经关联的分类
	*/
	public function getCateName($id)
	{
		$data = new CategoryData();
		return $data->getCateName($id);
	}
	
	/*public function suoyou()
	{
		$data = new CategoryData();
		return $data->getSy();
	}
	
	public function suoyou3()
	{
		$data = new CategoryData();
		return $data->getSy3();
	}
	
	public function suoyou2()
	{
		$data = new CategoryData();
		return $data->getSy2();
	}
	
	public function suoyou1()
	{
		$data = new CategoryData();
		return $data->getSy1();
	}*/
	
}
