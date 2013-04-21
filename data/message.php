<?php

class MessageData extends BaseData
{
	public function addMsg($model)
	{
		$this->setOrder(array('id'=>'desc'));
		$this->where(array('pid'=>$model->pid));
		$this->setLine('storey');
		$result = $this->findOne();
		if(empty($result->storey))
		{
			$model->storey = 1;
		}else{
			$model->storey = $result->storey+1;
		}
		$this->add($model);
	}
    public function getAll($pageCore,$pid,$isLastPage = false)
	{
		$sql = 'select count(*) as num from message as t1 join user as t2 on t2.id = t1.userid where pid = '.$pid;
		$row = $this->query($sql);
		$pageCore->count = $row[0]['num'];
		$pageCore->pageCount = ceil($pageCore->count / $pageCore->pageSize);
		if ($isLastPage) 
		{
			$pageCore->currentPage = $pageCore->pageCount;
		}
		$sql = 'select t1.*,t2.nickname from message as t1 join user as t2 on t2.id = t1.userid where pid = '.$pid.' order by id asc limit '.($pageCore->currentPage - 1)*$pageCore->pageSize.','.$pageCore->pageSize;
		$result = $this->query($sql,'MessageDataModel');
		return $result;
	}
}
