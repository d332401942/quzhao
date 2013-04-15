<?php

class SearchBusiness extends BaseBusiness
{
	
	public function searchProduct($pageCore, $keyword , $categoryId)
	{	
		$data = M('SearchData');
		$result = $data->searchProduct($pageCore, $keyword , $categoryId);		
		return $result;	
	}
	
	public function getAttrModelsByCategoryId($categoryId)
	{
		$data = M('categoryData');
	}
}
