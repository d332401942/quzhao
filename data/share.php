<?php

class ShareData extends BaseData
{

    public function addShare ($model)
    {
        $this->add($model);
    }
	
	public function findShare($pageCore,$cateId)
	{
		$this->setPage($pageCore);
		$this->setOrder(array('id' => 'desc'));
		$query = array();
		$query['status'] = 0;
		if($cateId)
		{
			$query['cateId'] = $cateId;
		}
		$this->where($query);
		$result = $this->findAll();
		return $result;
	}
	
	public function setState($id,$status)
	{
		$ids = is_array($id) ? $id : array($id);
		$sql = 'update share set status = '.$status . ' where id in ('.implode(',', $ids).')';
		$this->exec($sql);
	}
    
}
