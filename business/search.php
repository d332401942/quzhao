<?php

class SearchBusiness extends BaseBusiness
{
	
	public function searchProduct($pageCore, $keyword)
	{
		
		$data = M('SearchData');
		$result = $data->searchProduct($pageCore, $keyword);
		return $result;	
	}
}
