<?php

class KeywordsData extends BaseData
{
	public function getCount($pageCore, $time)
	{
		$now = time();
		if($time)
		{
			$sql = 'SELECT COUNT(DISTINCT keywords) as num FROM keywords where createtime >= '.($now - $time);
		}else{
			$sql = 'SELECT COUNT(DISTINCT keywords) as num  FROM keywords';
		}
		
		$row = $this->query ( $sql );
		$pageCore->count = $row [0] ['num'];
		$pageCore->pageCount = ceil ( $pageCore->count / $pageCore->pageSize );
		
		if($time)
		{
			$sql = 'SELECT count(*) as num,keywords FROM keywords where createtime >= '.($now - $time).' group by keywords limit '.($pageCore->currentPage - 1) * $pageCore->pageSize . ',' . $pageCore->pageSize;
		}else{
			$sql = 'SELECT count(*) as num,keywords FROM keywords group by keywords limit '.($pageCore->currentPage - 1) * $pageCore->pageSize . ',' . $pageCore->pageSize;
		}
		$result = $this->query($sql,'KeywordsDataModel');
		return $result;
	}
}
