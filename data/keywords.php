<?php

class KeywordsData extends BaseData
{

	public function getCount($pageCore, $time=false)
	{
		if ($time && $time == 1)
		{
			$time = date('Y-m-d');
			$dayTimeStr = strtotime($time);
			$dayTimeEnd = $time.' 11:59:59';
			$dayTimeEnd = strtotime($dayTimeEnd);
			$sql = 'SELECT count(*) as num FROM keywords where createtime > '.$dayTimeStr.' && createtime < ' .$dayTimeEnd. ' group by keywords';
		}
		elseif($time == 7)
		{
			
			$time = date('Y-m-d');
			$dayTimeStr = strtotime($time);
			$dayTimeStr = $dayTimeStr-604800;
			$dayTimeEnd = $time.' 11:59:59';
			$dayTimeEnd = strtotime($dayTimeEnd);
			$sql = 'SELECT count(*) as num FROM keywords where createtime > '.$dayTimeStr.' && createtime < ' .$dayTimeEnd. ' group by keywords';
		}
		elseif($time == 30)
		{
			$time = date('Y-m-d');
			$dayTimeStr = strtotime($time);
			$dayTimeStr = $dayTimeStr-2592000;
			$dayTimeEnd = $time.' 11:59:59';
			$dayTimeEnd = strtotime($dayTimeEnd);
			$sql = 'SELECT count(*) as num FROM keywords where createtime > '.$dayTimeStr.' && createtime < ' .$dayTimeEnd. ' group by keywords';
		}
		else
		{
			$sql = 'SELECT COUNT(DISTINCT keywords) as num  FROM keywords';
		}
		
		$row = $this->query ( $sql );
		$pageCore->count = $row [0] ['num'];
		$pageCore->pageCount = ceil ( $pageCore->count / $pageCore->pageSize );
		
		if ($time)
		{
			$sql = 'SELECT count(*) as num,keywords FROM keywords where createtime >= ' . ($now - $time) . ' group by keywords order by count(*) desc limit ' . ($pageCore->currentPage - 1) * $pageCore->pageSize . ',' . $pageCore->pageSize;
		}
		else
		{
			$sql = 'SELECT count(*) as num,keywords FROM keywords group by keywords order by count(*) desc limit ' . ($pageCore->currentPage - 1) * $pageCore->pageSize . ',' . $pageCore->pageSize;
		}
		$result = $this->query ( $sql, 'KeywordsDataModel' );
		return $result;
	}

}
