<?php

class HomeTjDataData extends BaseData
{
	
	/**
	 * 改变商品状态
	 * @param array $ids 商品ID
	 * @param int $state 状态值
	 */
	public function changeState($ids,$state)
	{
		$sql = 'update home_tj_data set state='.$state. ' where id in ('.implode(',',$ids).')';
		$this->exec($sql);
	}
	
    public function clearSort($ids)
    {
        if (!$ids)
        {
            return;
        }
        $ids = is_array($ids) ? $ids : array($ids);
        $sql = 'update home_tj_data set sort = 0 where id in ('.implode(',',$ids).')';
        $this->exec($sql);
    }
    
    /**
     * 设置推荐为 0
     * @param type $ids
     */
    public function clearTj($ids)
    {
        if (!$ids)
        {
            return;
        }
        $ids = is_array($ids) ? $ids : array($ids);
        $sql = 'update home_tj_data set istj = 0 where id in ('.implode(',',$ids).')';
        $this->exec($sql);
    }
    
    public function clearHot($ids)
    {
        if (!$ids)
        {
            return;
        }
        $ids = is_array($ids) ? $ids : array($ids);
        $sql = 'update home_tj_data set ishot = 0 where id in ('.implode(',',$ids).')';
        $this->exec($sql);
    }
    
	/**
	 * 得到首页9.9包邮的数据
	 */
	public function nineModel()
	{
		$sql = 'select * from home_tj_data where cid = 1 and state != '.HomeTjDataDataModel::STATE_DOWN.' and ';
		$sql .= ' istj = ' . HomeTjDataDataModel::ISTJ_IS .' and time_end > '.time().' order by sort desc, ltime desc limit 6';
		$models = $this->query($sql,'HomeTjDataDataModel');
		return $models;
	}
	
	/**
	 * 得到超值单品的数据
	 * @param array $cids 单品所在分组
	 */
	public function getDpModels()
	{
		$sql = 'select * from home_tj_data where cid != 1 and state != '.HomeTjDataDataModel::STATE_DOWN;
		$sql .= ' and istj = '.HomeTjDataDataModel::ISTJ_IS .' order by sort desc, id desc limit 4';
		$models = $this->query($sql,'HomeTjDataDataModel');
		return $models;
	}
	
	/**
	 * 得到单品栏目页面数据
	 */
	public function getDp($pageCore)
	{
		$start = ($pageCore->currentPage - 1) * $pageCore->pageSize;
		$end = $pageCore->pageSize;
		$sql = 'select t1.* from home_tj_data as t1 inner join home_tj_class as t2 on t1.cid = t2.id where (t2.id = 2 or t2.pid = 2) and t1.state = '.HomeTjDataDataModel::STATE_HAVE.' order by t1.sort desc, t1.id desc limit '.$start.','.$end;
        $countSql = 'select count(*) from home_tj_data as t1 inner join home_tj_class as t2 on t1.cid = t2.id where (t2.id = 2 or t2.pid = 2) and t1.state = '.HomeTjDataDataModel::STATE_HAVE;
        $count = $this->queryOne($countSql);
        if (!$count)
        {
            return array();
        }
        $count = (int)array_pop($count);
        if (!$count)
        {
            return array();
        }
        $pageCore->count = $count;
        $pageCore->pageCount = ceil($count / $pageCore->pageSize);
		$models = $this->query($sql,'HomeTjDataDataModel');
		return $models;
	}
	
	/**
	 * 得到首页推荐单品
	 * @param int $num 取几条
	 */
	public function getTjDpModels($num)
	{
		$num = (int)$num;
		$sql = 'select t1.* from home_tj_data as t1 inner join home_tj_class as t2 on t1.cid = t2.id where (t2.id = 2 or t2.pid = 2) and t1.state = '.HomeTjDataDataModel::STATE_HAVE.' and ishot = '.HomeTjDataDataModel::ISTJ_IS.' order by t1.sort desc, t1.id desc limit '.$num;
		$models = $this->query($sql,'HomeTjDataDataModel');
		return $models;
	}
	
	/**
	 * 得到用户浏览单品的记录
	 * @param array $arrIds 浏览的ID
	 */
	public function dpBrowseHistoryModels($arrIds)
	{
		if (!$arrIds)
		{
			return array();
		}
		$sql = 'select * from home_tj_data where id in ('.implode(',', $arrIds).') and state = '.HomeTjDataDataModel::STATE_HAVE;
		$models = $this->query($sql,'HomeTjDataDataModel');
		$idToModel = array();
		foreach ($models as $model)
		{
			$idToModel[$model->id] = $model;
		}
		$result = array();
		foreach ($arrIds as $id)
		{
			if (isset($idToModel[$id]))
			{
				$result[] = $idToModel[$id];
			}
		}
		return $result;
	}
}