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
		$user = json_decode($_COOKIE['UserInfo']);
		$name = $user->UserName;
		$sql = 'update home_tj_data set state='.$state.' , ltime = '.time().' , audit = '."'$name'".' where id in ('.implode(',',$ids).')';
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
    
    /**
     * 前台超级会员调整排序
     */
    public function upSort($id)
    {
    	$sql = 'update home_tj_data set sort = sort + 1 where id = ' . $id;
    	$this->exec($sql);
    }
    
    /**
     * 前台超级会员调整排序
     */
    public function defSort($id)
    {
    	$sql = 'update home_tj_data set sort = 0 where id = ' . $id;
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
	public function getDp($pageCore,$cateId=false)
	{
		$start = ($pageCore->currentPage - 1) * $pageCore->pageSize;
		$end = $pageCore->pageSize;
		if($cateId)
		{
			$sql = 'select * from home_tj_data where cid = '.$cateId.' and state = '.HomeTjDataDataModel::STATE_HAVE.' order by ltime desc,sort desc limit '.$start.','.$end;
			$countSql = 'select count(*) from home_tj_data where cid = '.$cateId.' and state = '.HomeTjDataDataModel::STATE_HAVE;
		}else{
			$sql = 'select t1.* from home_tj_data as t1 inner join home_tj_class as t2 on t1.cid = t2.id where (t2.id = 2 or t2.pid = 2) and  t1.state = '.HomeTjDataDataModel::STATE_HAVE.' order by t1.ltime desc, t1.sort desc limit '.$start.','.$end;
			$countSql = 'select count(*) from home_tj_data as t1 inner join home_tj_class as t2 on t1.cid = t2.id where (t2.id = 2 or t2.pid = 2) and t1.state = '.HomeTjDataDataModel::STATE_HAVE;
		}
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
	 /*
	 *	得到会员喜欢商品
	 */
	public function getUserLove($pageCore,$userid)
	{
		$sql = 'select count(*) as num from love as t1 join home_tj_data as t2 on t2.id = t1.home_tj_data_id where t1.userid = '.$userid;
		$row = $this->query($sql);
		$pageCore->count = $row[0]['num'];
		$pageCore->pageCount = ceil($pageCore->count / $pageCore->pageSize);
		$sql = 'select t2.* from love as t1 join home_tj_data as t2 on t2.id = t1.home_tj_data_id where t1.userid = '.$userid.' order by id desc limit '.($pageCore->currentPage - 1)*$pageCore->pageSize.','.$pageCore->pageSize;
		$result = $this->query($sql,'HomeTjDataDataModel');
		return $result;
	}
	
	 /*
	  *	得到会员喜欢商品
	  */
	public function getLoveModel()
	{
		$sql = 'select * from home_tj_data order by lovenumber desc limit 3';
		$result = $this->query($sql,'HomeTjDataDataModel');
		return $result;
	}
	
	public function loveNum($id, $loveType = LoveDataModel::LOVE_TYPE_HOME_TJ_DATA)
	{
		if ($loveType == LoveDataModel::LOVE_TYPE_SEARCH)
		{
			$data = new ProductData();
			$data->loveNum($id);
		}
		else
		{
			$sql = 'update home_tj_data set lovenumber = lovenumber+1 where id = '.$id;
			$this->exec($sql);
		}
	}
	
	/*
	*	添加产品检查名称是否已经存在
	*/
	public function findOneByName($name)
	{
		$this->where(array('name'=>$name));
		$res = $this->findOne();
		return $res;
	}
	
	/**
	 * 按时间算出兼职发布的顺
	 * @param string $isPart 是否兼职添加   0,查询所有，1查询兼职，2查询抓取
	 * @param string $startTime 开始时间戳
	 * @param string $endTime 结束时间戳
	 * @param string $state false 查询全部
	 * @param string $isPart 是否兼职发布
	 * @return unknown	
	 */
	public function getDayNumber($startTime, $endTime, $state = false, $isPart = false)
	{
		$sql = 'select t2.username,t2.id,count(*) as num from home_tj_data as t1 inner join brandadmin as t2 on t2.id = t1.userid ';
		$where = ' where 1 = 1 ';
		if ($isPart == 1)
		{
			$where .= 'and t1.tempType = 1';
		}
		else if ($isPart == 2)
		{
			$where .= 'and t1.tempType = 0';
		}
		
		$start = strtotime(date('Y-m-d'));
		$end = strtotime(date('Y-m-d', strtotime('+1 day')));
		if ($startTime && $endTime)
		{
			$start = strtotime($startTime);
			$end = strtotime($endTime);
		}
		$where .= ' and t1.ltime >= '.$start.' and t1.ltime <= '.$end;
		
		if ($state == 1)
		{
			$where .= ' and state = 1';
		}
		else
		{
			$where .= ' and state != 1';
		}
		$sql .= $where;
		$sql .= ' group by t2.id';
		$statement = $this->run($sql);
		$result = array(); 
		while($row = $statement->fetch(PDO::FETCH_ASSOC))
		{
			$result[$row['id']] = $row;
		}
		return $result;
	}
}
