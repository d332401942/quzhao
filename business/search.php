<?php

class SearchBusiness extends BaseBusiness
{
	
	public function searchProduct($pageCore, $keyword , $categoryId = null, $attrArr = array(), $sort = null)
	{	
		$data = M('SearchData');
		$categoryData = M('CategoryData');
		$categoryIds = $categoryData->getChildrenIds($categoryId);
		$result = $data->searchProduct($pageCore, $keyword , $categoryIds,$attrArr, $sort);		
		return $result;	
	}

	public function getRecommendModels($keyword)
	{
	}
	
	/**
     * 得到用户浏览搜索的记录
     * @param array $arrIds 浏览的ID
     */
    public function searchBrowseHistoryModels($arrIds)
    {
        $data = new ProductData();
        return $data->searchBrowseHistoryModels($arrIds);
    }
}
