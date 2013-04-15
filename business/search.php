<?php

class SearchBusiness extends BaseBusiness
{
	
	public function searchProduct($pageCore, $keyword , $categoryId = null)
	{	
		$data = M('SearchData');
		$categoryData = M('CategoryData');
		$categoryIds = $categoryData->getChildrenIds($categoryId);
		$result = $data->searchProduct($pageCore, $keyword , $categoryIds);		
		return $result;	
	}
}
