<?php

class BrandData extends BaseData
{
    public function getAll($pageCore)
	{
		$sql = 'SELECT count(*) as num FROM brand AS t1 INNER JOIN brand_cate AS t2 ON t2.id = t1.cate LEFT JOIN brand_column AS t4 ON t4.brandid = t1.id LEFT JOIN child_cate AS t5 ON t5.id = t4.cateid JOIN brandadmin AS t3 ON t3.id = t1.userid where t1.userid = ' .$_COOKIE['brand_id'];
		$row = $this->query ( $sql );
		$pageCore->count = $row [0] ['num'];
		$pageCore->pageCount = ceil ( $pageCore->count / $pageCore->pageSize );
		
		$sql = 'SELECT t1.*, t2. NAME AS cateName, t3.username AS username, t5. NAME AS columnname, t5.id AS columnid FROM brand AS t1 INNER JOIN brand_cate AS t2 ON t2.id = t1.cate LEFT JOIN brand_column AS t4 ON t4.brandid = t1.id LEFT JOIN child_cate AS t5 ON t5.id = t4.cateid JOIN brandadmin AS t3 ON t3.id = t1.userid where t1.userid = ' .$_COOKIE['brand_id'] . 
		' limit ' . ($pageCore->currentPage - 1) * $pageCore->pageSize . ',' . $pageCore->pageSize;
		$models = array();
		$statemem = $this->run($sql);
		while($row = $statemem->fetch(PDO::FETCH_ASSOC))
		{
			$brandId = $row['id'];
			if (empty($models[$brandId]))
			{
				$brandData = new BrandDataModel();
				foreach ($brandData as $key => $val)
				{
					if (isset($row[$key]))
					{
						$brandData->$key = $row[$key];
					}
				}
				$models[$brandId] = $brandData;
			}
			if (empty($row['columnid']))
			{
				continue;
			}
			$childCateModel = new Child_cateDataModel();
			$childCateModel->id = $row['columnid'];
			$childCateModel->name = $row['columnname'];
			$models[$brandId]->colums[$childCateModel->id] = $childCateModel;
		}
		return $models;
	}
	
	public function getOne($id)
	{
		$sql = 'SELECT t1.*, t2. NAME AS cateName, t3.username AS username, t5. NAME AS columnname, t5.id AS columnid FROM brand AS t1 INNER JOIN brand_cate AS t2 ON t2.id = t1.cate LEFT JOIN brand_column AS t4 ON t4.brandid = t1.id LEFT JOIN child_cate AS t5 ON t5.id = t4.cateid JOIN brandadmin AS t3 ON t3.id = t1.userid where t1.id = '.$id.' AND t1.userid = '. $_COOKIE['brand_id'].' limit 1';
		$models = array();
		$statemem = $this->run($sql);
		while($row = $statemem->fetch(PDO::FETCH_ASSOC))
		{
			$brandId = $row['id'];
			if (empty($models[$brandId]))
			{
				$brandData = new BrandDataModel();
				foreach ($brandData as $key => $val)
				{
					if (isset($row[$key]))
					{
						$brandData->$key = $row[$key];
					}
				}
				$models[$brandId] = $brandData;
			}
			if (empty($row['columnid']))
			{
				continue;
			}
			$childCateModel = new Child_cateDataModel();
			$childCateModel->id = $row['columnid'];
			$childCateModel->name = $row['columnname'];
			$models[$brandId]->colums[$childCateModel->id] = $childCateModel;
		}
		return $models;
	}
	
	public function delMsg($id)
	{
		$ids = is_array($id) ? $id : array($id);
		$sql = 'delete from brand where id in ('.implode(',', $ids).')';
		$this->exec($sql);
	}
}

