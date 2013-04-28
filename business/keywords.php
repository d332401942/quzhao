<?php

class KeywordsBusiness extends BaseBusiness
{
	public function getCount($pageCore, $time)
	{
		$data = M('KeywordsData');
		return $data->getCount($pageCore, $time);
	}
}
