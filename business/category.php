<?php

class CategoryBusiness extends BaseBusiness
{

	public function search($keyword)
	{
		$searchData = M('SearchData');
		$categoryModels = array();
		$categoryIdToCount = $searchData->getCategoryIdToCount($keyword);
		if (empty($categoryIdToCount))
		{
			return $categoryIdToCount;
		}
		$categoryIds = array_keys($categoryIdToCount);
		$categoryModels = $this->getCompleteCategoryByIds($categoryIds);
		return $categoryModels;
	}

	/**
	 * 通过分类ID获取他的上级已经下级的所有数据
	 */
	public function getCompleteCategoryByIds($ids)
	{
		$data = M('CategoryData');
		$models = $data->getCompleteCategoryByIds($ids);
		return $models;
	}
	
	public function getAttrModelsByCategoryId($categoryId)
	{
		$data = M('CategoryData');
		$attrModel = $data->getAttrId($categoryId);
		$result = array();
		if (empty($attrModel))
		{
			return $result;
		}
		$result = $data->getAttrDbs($attrModel->attrid);
		return $result;
	}
}
