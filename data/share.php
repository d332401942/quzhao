<?php

class ShareData extends BaseData
{

    public function addShare ($model)
    {
        $this->add($model);
    }
	
	public function findShare($pageCore,$cateId)
	{
		$where = 't1.status = 0';
		if($cateId)
		{
			$where .= 'AND t1.cateid = '.$cateId;
		}
		$sql = "select count(*) as count from share as t1 join user as t2 on t2.id = t1.userid where ".$where;
		$count = $this->query($sql);
		$pageCore->count = $count[0]['count'];
		$pageCore->pageCount = ceil($pageCore->count / $pageCore->pageSize);
		$sql = 'select t1.*,t2.email from share as t1 join user as t2 on t2.id = t1.userid where '.$where.' order by id desc limit '.($pageCore->currentPage-1)*$pageCore->pageSize.','.$pageCore->pageSize;
		$result = $this->query($sql,'ShareDataModel');
		return $result;
	}
	
	public function setState($id,$status)
	{
		$ids = is_array($id) ? $id : array($id);
		$sql = 'update share set status = '.$status . ' where id in ('.implode(',', $ids).')';
		$this->exec($sql);
	}
	
	public function getShare($pageCore,$userid)
	{
		$this->setPage($pageCore);
		$this->setOrder(array('id'=>'desc'));
		$this->where(array('userid'=>array('='=>$userid)));
		$result = $this->findAll();
		return $result;
	}
    
}
