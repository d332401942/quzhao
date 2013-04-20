<?php

class HomeTjDataBusiness extends BaseBusiness
{

    public function add($model)
    {
        $data = new HomeTjDataData();
        $this->checkMustFill($model);
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
	 */
	 public function loveNum($id)
	 {
		$data = new HomeTjDataData();
		$sql = 'update home_tj_data set lovenumber = lovenumber+1 where id = '.$id;
		$data->exec($sql);
	 }
	 
    public function getOneById($id)
    {
        $data = new HomeTjDataData();
        return $data->getOneById($id);
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
    public function findAll($pageCore, $cid = array(), $state = array(), $fid = null, $site = null, $istj = null, $ishot = null, $sort = array('sort' => 'desc', 'ctime' => 'desc'))
    {
        $data = new HomeTjDataData();
        $data->setOrder($sort);
        $data->setPage($pageCore);
        $query = array();
        if (!empty($cid))
        {
            $query['cid'] = array('in' => $cid);
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
        if ($query)
        {
            $data->where($query);
        }

        return $data->findAll();
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

    public function delById($id)
    {
        $data = new HomeTjDataData();
        $data->delById($id);
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
