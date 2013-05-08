<?php

class HomeTjDataBusiness extends BaseBusiness
{

    public function add($model)
    {
        $data = new HomeTjDataData();
        $this->checkMustFill($model);
<<<<<<< HEAD
		$result = $data->findOneByName($model->name);
		if ($result)
		{
			$this->throwException('商品名称已经存在');
		}
=======
		$sql = "select * from home_tj_data where name = '$model->name'";
		$res = $data->query($sql);
		if (!empty($res))
        {
            $this->throwException('该商品名称已经存在');
        }
>>>>>>> be402fcb213ef42afc8970f217ec817b0601e574
        $data->add($model);
    }

    public function updateModel($model)
    {
        $data = new HomeTjDataData();
        $this->checkMustFill($model);
        $data->updateModel($model);
    }
	
	/**
	 * 修改产品喜欢次数
	 * var $isAdd 真加，假减
	 */
	 public function loveNum($id, $loveType = LoveDataModel::LOVE_TYPE_HOME_TJ_DATA, $isAdd = true)
	{
		$data = new HomeTjDataData();
		$data->loveNum($id, $loveType);
	}
	
	/**
	 * 前台超级会员调整排序
	 */
	public function upSort($id, $userId)
	{
		$userData = new UserData();
		$userModel = $userData->getOneById($userId);
		if ($userModel->power != UserDataModel::POWER_SUPER)
		{
			$this->throwException('权限不够', CodeException::USER_NOT_POWER);
		}
		$data = new HomeTjDataData();
		$data->upSort($id);
	}
	
	/**
	 * 前台超级会员调整排序
	 */
	public function defSort($id, $userId)
	{
		$userData = new UserData();
		$userModel = $userData->getOneById($userId);
		if ($userModel->power != UserDataModel::POWER_SUPER)
		{
			$this->throwException('权限不够', CodeException::USER_NOT_POWER);
		}
		$data = new HomeTjDataData();
		$data->defSort($id);
	}
	 
	 /*
	*得到会员喜欢商品
	*/
	public function getUserLove($pageCore,$userid)
	{
		$data = new HomeTjDataData();
		$result = $data->getUserLove($pageCore,$userid);
		return $result;
	}
	
	 /*
	*得到喜欢商品次数最多的三个
	*/
	public function getLoveModel()
	{
		$data = new HomeTjDataData();
		$result = $data->getLoveModel();
		return $result;
	}
    public function getOneById($id,$tempType=false,$userid = false,$del=false)
    {
        $data = new HomeTjDataData();
		$where = 'id = '.$id;
		if($tempType)
		{
			$where .= ' AND tempType = 1';
		}
		if($userid)
		{
			$where .= ' AND userid = '.$userid;
		}
		if($del)
		{
			$where .= ' AND state != 4';
		}
		$sql = 'select * from home_tj_data where '.$where;
		$res = $data->query($sql,'HomeTjDataDataModel');
		return $res;
       // return $data->getOneById($id);
    }

    /**
     * 得到单品栏目页面数据
     */
    public function getDp($pageCore,$cateId)
    {
        $data = new HomeTjDataData();
        return $data->getDp($pageCore,$cateId);
    }

    /**
     * 设置排序为 0
     * @param type $ids
     */
    public function clearSort($ids)
    {
        $data = new HomeTjDataData();
        $data->clearSort($ids);
    }

    /**
     * 设置推荐为 0
     * @param type $ids
     */
    public function clearTj($ids)
    {
        $data = new HomeTjDataData();
        $data->clearTj($ids);
    }

    public function clearHot($ids)
    {
        $data = new HomeTjDataData();
        $data->clearHot($ids);
    }

    /**
     * 得到首页推荐单品
     * @param int $num 取几条
     */
    public function getTjDpModels($num)
    {
        $data = new HomeTjDataData();
        return $data->getTjDpModels($num);
    }

    /**
     * 得到用户浏览单品的记录
     * @param array $arrIds 浏览的ID
     */
    public function dpBrowseHistoryModels($arrIds)
    {
        $data = new HomeTjDataData();
        return $data->dpBrowseHistoryModels($arrIds);
    }

    /**
     * 得到商品列表
     * @param object $pageCore 
     * @param array $cid 分类ID
     * @param array $state 状态
     */
    public function findAll($pageCore, $cid = array(), $state = array(), $fid = null, $site = null, $istj = null, $ishot = null, $tempType = false,$userid = false,$del=false, $sort = array('sort' => 'desc', 'ctime' => 'desc'))
    {
        $data = new HomeTjDataData();
        $data->setOrder($sort);
        $data->setPage($pageCore);
        $query = array();
        if (!empty($cid))
        {
            $query['cid'] = array('in' => $cid);
        }
		if($del)
		{
			$query['state'] = array('!=' => 4);
		}
        if (!empty($state))
        {
            $query['state'] = array('in' => $state);
        }
        if ($fid)
        {
            $query['fid'] = $fid;
        }
        if ($site)
        {
            $query['site'] = $site;
        }
        if ($istj !== null)
        {
            if ($istj == 1)
            {
                $query['istj'] = $istj;
            }
            else
            {
                $query['istj'] = array('!=' => 1);
            }
        }
        if ($ishot !== null)
        {
            if ($ishot == 1)
            {
                $query['ishot'] = $ishot;
            }
            else
            {
                $query['ishot'] = array('!=' => 1);
            }
        }
		
		if($tempType == 1)
		{
			$query['tempType'] = 1;
		}
		else if ($tempType == 2)
		{
			$query['tempType'] = 0;
		}
		if($userid)
		{
			$query['userid'] = $userid;
		}
        if ($query)
        {
            $data->where($query);
        }
		$data->setOrder(array('ctime'=>'desc'));
        return $data->findAll();
    }

	public function getAllTotal($tempType = false, $userid = false ,$strTime = false,$endTiem =false,$yueStr = false,$yueEnd =false)
	{
		$data = new HomeTjDataData();
		if($yueStr && $yueEnd)
		{
			$sql = 'select count(*) as num from home_tj_data where tempType = 1 AND userid = '. $userid.' AND ltime > '.$yueStr.' && ltime < '.$yueEnd;
		}else if($strTime && $endTiem){
			$sql = 'select count(*) as num from home_tj_data where tempType = 1 AND userid = '. $userid.' AND ltime > '.$strTime.' && ltime < '.$endTiem;
		}else{
			$sql = 'select count(*) as num from home_tj_data where tempType = 1 AND userid = '. $userid;
		}
		$total = $data->query($sql);
		return $total[0]['num'];
	}
	
	public function tgCount($tempType = false, $userid = false,$strTime = false,$endTiem =false)
	{
		$data = new HomeTjDataData();
		if($strTime && $endTiem)
		{
			$sql = 'select count(*) as num from home_tj_data where tempType = 1 AND state in(1,4)  AND userid = '. $userid.' AND ctime > '.$strTime.' && ctime < '.$endTiem;
		}else{
			$sql = 'select count(*) as num from home_tj_data where tempType = 1 AND state in(1,4) AND userid = '. $userid;
		}
		$total = $data->query($sql);
		return $total[0]['num'];
	}
    /**
     * 改变商品状态
     * @param array $ids 商品ID
     * @param int $state 状态值
     */
    public function changeState($ids, $state)
    {
        if (empty($ids))
        {
            $this->throwException('商品id不能为空');
        }
        $data = new HomeTjDataData();
        $data->changeState($ids, $state);
    }

    /**
     * 得到首页9.9包邮的数据
     */
    public function nineModel()
    {
        $data = new HomeTjDataData();
        $models = $data->nineModel();
        return $models;
    }

    public function search($pageCore, $keyword)
    {
        $sort = array('sort' => 'desc', 'ctime' => 'desc');
        $data = new HomeTjDataData();
        $data->setOrder($sort);
        $data->setPage($pageCore);
        $query = array('name' => array('like' => '%' . $keyword . '%'));
        $data->where($query);
        $models = $data->findAll();
        return $models;
    }

    /**
     * 得到超值单品的数据
     * @param array $cids 单品所在分组
     */
    public function getDpModels()
    {
        $data = new HomeTjDataData();
        $models = $data->getDpModels();
        return $models;
    }

    private function checkMustFill($model)
    {
        if (empty($model->name))
        {
            $this->throwException('商品名称必必须填写');
        }
		if (empty($model->fromName))
        {
            $this->throwException('商品来源名称必必须填写');
        }
        if (empty($model->cid))
        {
            $this->throwException('商品类容必须填写');
        }
        if (empty($model->href))
        {
            $this->throwException('商品连接必须填写');
        }
        if (empty($model->info))
        {
            $this->throwException('商品介绍必须填写');
        }
        if (empty($model->fitsex))
        {
        	$this->throwException('商品适合性别必须选择');
        }
    }

    /**
     * 把导入过来的数据转换成商品实体
     * @param unknown_type $netId
     */
    public function getNetDataToModel($netId)
    {
        $netDataBusiness = new NetDataBusiness();
        $netDataModel = $netDataBusiness->getOneById($netId);

        if (!$netDataModel)
        {
            return null;
        }

        $model = new HomeTjDataDataModel();
        $this->setCid($model, $netDataModel);
        $this->setFid($model, $netDataModel);
        $this->setSite($model, $netDataModel);
        $model->name = $netDataModel->name;
        $model->info = $netDataModel->info;
        $model->href = $netDataModel->href;
        $model->pic = $netDataModel->pic;
        $model->title = $netDataModel->ext2;
        return $model;
    }

    public function delById($id,$del=false,$userid = false)
    {
        $data = new HomeTjDataData();
		if($del)
		{
			$sql = 'update home_tj_data set state = 4 where id = '.$id;
		}else if($userid)
		{
			$sql = 'delete from home_tj_data where id = '.$id . ' AND userid = '.$_COOKIE['brand_id'];
		}else{
			$sql = 'delete from home_tj_data where id = '.$id;
		}
		$data->exec($sql);
    }

    /* private function setPic($model,$netDataModel)
      {
      $picUrl = $netDataModel->pic;
      $extensionName = pathinfo($picUrl,PATHINFO_EXTENSION);
      $path = 'public/uploads/inlcude';
      if (!file_exists($path))
      {
      mkdir($path);
      }
      $pic = $path .'/'. microtime(true) .rand(10000, 99999).'.'.$extensionName;
      $content = file_get_contents($picUrl);
      $model->pic = $pic;
      } */

    /**
     * 设置商品来源网站
     * @param unknown_type $model
     * @param unknown_type $netDataModel
     */
    private function setFid($model, $netDataModel)
    {
        $sourceName = $netDataModel->class3;
        $sourceBusiness = new NetDataSourceBusiness();
        $sourceModel = $sourceBusiness->getByName($sourceName);
        if (!$sourceModel)
        {
            $sourceModel = new NetDataSourceDataModel();
            $sourceModel->name = $sourceName;
            $sourceModel->isuse = NetDataSourceDataModel::IS_USE_YES;
            $sourceBusiness->add($sourceModel);
        }
        else if ($sourceModel->isuse != NetDataSourceDataModel::IS_USE_YES)
        {
            $sourceModel->isuse = NetDataSourceDataModel::IS_USE_YES;
            $sourceBusiness->updateModel($sourceModel);
        }
        $model->fid = $sourceModel->id;
    }

    /**
     * 设置抓取来源网站
     * @param unknown_type $model
     * @param unknown_type $netDataModel
     */
    private function setSite($model, $netDataModel)
    {
        $siteName = $netDataModel->site;
        if (!$siteName)
        {
            return;
        }
        $netDataSiteBusiness = new NetDataSiteBusiness();
        $siteModel = $netDataSiteBusiness->findByName($siteName);
        if (!$siteModel)
        {
            $siteModel = new NetDataSiteDataModel();
            $siteModel->name = $siteName;
            $siteModel->isuse = NetDataSiteDataModel::IS_USE_TYPE_YES;
            $netDataSiteBusiness->add($siteModel);
        }
        else if ($siteModel->isuse != NetDataSiteDataModel::IS_USE_TYPE_YES)
        {
            $siteModel->isuse = NetDataSiteDataModel::IS_USE_TYPE_YES;
            $netDataSiteBusiness->updateModel($siteModel);
        }
        $model->site = $siteModel->id;
    }

    /**
     * 设置商品分类
     * @param unknown_type $model
     * @param unknown_type $netDataModel
     */
    private function setCid($model, $netDataModel)
    {
        $groupStr = $netDataModel->ext1;
        $groupArr = explode('/', $groupStr);
        $className = array_shift($groupArr);
        if (empty($className))
        {
            return;
        }
        //如果是9.9则不添加分类
        if ($netDataModel->classid == 0)
        {
            $model->cid = 1;
        }
		else
		{
			$model->cid = 2;
		}
		return;
        $tjClassid = $netDataModel->tjClassid;
        if ($tjClassid !== 1 && $tjClassid !== 2)
        {
            return;
        }
        //通过组名查出分组信息
        $homeTjClass = new HomeTjClassBusiness();
        $classModel = $homeTjClass->getByName($className);
        if (!$classModel)
        {
            $classModel = new HomeTjClassDataModel();
            $classModel->name = $className;
            $classModel->pid = $tjClassid;
            $classModel->sort = 0;
            $classModel->isuse = HomeTjClassDataModel::IS_USE_TYPE_YES;
            $homeTjClass->add($classModel);
        }
        else if ($classModel->isuse != HomeTjClassDataModel::IS_USE_TYPE_YES)
        {
            $classModel->isuse = HomeTjClassDataModel::IS_USE_TYPE_YES;
            $homeTjClass->updateModel($classModel);
        }
        $model->cid = $classModel->id;
    }

}
