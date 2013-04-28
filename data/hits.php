<?php

class HitsData extends BaseData
{

	public function getNineHits($pageCore, $time, $dataId,$cid )
	{
		if($cid == 1)
		{
			$where = 'where t1.type = 1 and t2.cid = 1';
		}else{
			$where = 'where t1.type = 1 and t2.cid in(2,49,50,51,52,53,54,55,56,57,58,59)';
		}
		$now = time();
		if ($dataId)
		{
			$where .= ' and t2.id = '. $dataId;
		}
		else if ($time) 
		{
			$where .= ' and t1.time >= '. ($now - $time);
		}
		$countSql = 'select COUNT(DISTINCT data_id) as num from hits as t1 inner join home_tj_data as t2 on t1.data_id = t2.id '. $where;
		$result = $this->queryOne($countSql);
		$num = 0;
		if ($result)
		{
			$num = (int)$result['num'];
		}
		if (!$num)
		{
			return array();
		}
		$pageCore->count = $num;
		$pageCore->pageCount = ceil ( $pageCore->count / $pageCore->pageSize );
		$sql = 'select t2.*,count(*) as hitnum,t1.time as hitstime from hits as t1 inner join home_tj_data as t2 on t1.data_id = t2.id '. $where .' group by t1.data_id order by count(*) desc limit '.($pageCore->currentPage - 1) * $pageCore->pageSize . ',' . $pageCore->pageSize;
		$result = $this->query($sql);
		$models = array();
		foreach ($result as $arr)
		{
			$model = new HomeTjDataDataModel();
			foreach ($arr as $k => $v)
			{
				$model->$k = $v;
			}
			$models[] = $model;
		}
		return $models;
	}
    
}
