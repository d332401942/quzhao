<?php

class SearchBusiness extends BaseBusiness
{
	
	public function searchProduct($pageCore, $keyword , $categoryId = null, $attrArr = array(), $sort = null)
	{	
		$data = M('SearchData');
		$result = $data->searchProduct($pageCore, $keyword , $categoryId,$attrArr, $sort);		
		return $result;	
	}
	
	/**
	 * 搜索关键字都有的分类和数木
	 * @param string $keyword
	 * @param id $category 类别ID
	 * @param array $attrArr 商品属性
	 * @return unknown
	 */
	public function searchBrandIdToCount($keyword , $category, $attrArr)
	{
		$data = new SearchData();
		$brandIdToCount = $data->searchBrandIdToCount($keyword , $category, $attrArr);
		if (!$brandIdToCount)
		{
			$brandIdToCount = array();
		}
		return $brandIdToCount;
	}

	public function getRecommendModels($keyword)
	{
		$data = M('SearchData');
		$recommendModels = $data->getRecommendModels($keyword);
		return $recommendModels;
	}
	
	public function logKeywords($keywords, $ip)
	{
		$data = M('SearchData');
		$data->logKeywords($keywords, $ip);
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
