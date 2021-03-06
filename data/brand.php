<?php

class BrandData extends BaseData
{
    public function getAll($pageCore)
	{
		//前台兼职列表
		$sql = 'SELECT count(*) as num FROM brand AS t1 JOIN brandadmin AS t2 ON t2.id = t1.userid JOIN brand_name as t3 on t3.id = t1.brand_name_id JOIN merchants as t4 on t4.id = t1.merchantsId where t1.userid = ' .$_COOKIE['brand_id'];
		$row = $this->query ( $sql );
		$pageCore->count = $row [0] ['num'];
		$pageCore->pageCount = ceil ( $pageCore->count / $pageCore->pageSize );
		$sql = 'SELECT t1.*, t2.username AS username,t3.name as bn_name,t4.name as m_name FROM brand AS t1 JOIN brandadmin AS t2 ON t2.id = t1.userid JOIN brand_name as t3 on t3.id = t1.brand_name_id JOIN merchants as t4 on t4.id = t1.merchantsId where t1.userid = ' .$_COOKIE['brand_id'] . 
		' limit ' . ($pageCore->currentPage - 1) * $pageCore->pageSize . ',' . $pageCore->pageSize;
		$result = $this->query($sql,'BrandDataModel');
		return $result;
	}
	
	//后台管理列表
	public function getAll3($pageCore,$state = false,$id = false,$temp = false)
	{
		$where = 't1.id > 0';
		if (!empty($state))
        {
			$where .= ' AND t1.state in ('.$state.')';
        }
		
		if($id)
		{
			$where .= ' AND t1.id = '.$id;
		}
		if($temp == 1)
		{
			$where .= ' AND t1.temp = 1';
		}elseif($temp == 2)
		{
			$where .= ' AND t1.temp = 0';
		}
		$sql = 'SELECT count(*) as num FROM brand AS t1 JOIN brandadmin AS t2 ON t2.id = t1.userid JOIN brand_name as t3 on t3.id = t1.brand_name_id JOIN merchants as t4 on t4.id = t1.merchantsId where '.$where;
		$row = $this->query ( $sql );
		$pageCore->count = $row [0] ['num'];
		$pageCore->pageCount = ceil ( $pageCore->count / $pageCore->pageSize );
		$sql = 'SELECT t1.*, t2.username AS username,t3.name as bn_name,t4.name as m_name FROM brand AS t1 left JOIN brandadmin AS t2 ON t2.id = t1.userid left JOIN brand_name as t3 on t3.id = t1.brand_name_id JOIN merchants as t4 on t4.id = t1.merchantsId where '.$where.' order by id desc limit ' . ($pageCore->currentPage - 1) * $pageCore->pageSize . ',' . $pageCore->pageSize;
		$result = $this->query($sql,'BrandDataModel');
		return $result;
	}
	
	//前台页面数据
	 public function getAll2($pageCore,$cid = false,$letter = false,$mid= false,$num = false)
	{
		if($num == 1)
		{
			$sql = 'SELECT bn.zhekou as bn_zhekou, bn.id AS bn_id, bn. NAME AS bn_name, bn.image AS bn_image, bn.bc_name AS bc_name, m. NAME AS m_name, m.id AS m_id, b.url AS b_url,b.rebate as b_rebate,b.maxrebate as b_maxrebate FROM ( SELECT b.*, bc.id AS bc_id, bc.`name` AS bc_name FROM brand_name AS b INNER JOIN brand_cate AS bc ON bc.id = b.cateid JOIN brand as brand on brand.brand_name_id = b.id where brand.state = 1 AND brand.istj = 1 AND brand.end_time > '.time().' order by brand.sort desc, brand.id desc limit 10) AS bn INNER JOIN brand AS b ON b.brand_name_id = bn.id INNER JOIN merchants AS m ON m.id = b.merchantsId where b.state = 1 AND b.istj = 1 AND b.end_time > '.time().' order by b.sort,desc, b.id desc';
		
		}
		else{
			$where = ' AND brand.id > 0';
			$where2 = ' AND b.id > 0';
			if($cid)
			{
				$where = ' AND b.cateid = '.$cid;
				$where2 = ' AND bn.cateid = '.$cid;
			}
			if($letter)
			{
				$where = " AND b.letter = '".$letter."'";
				$where2 = " AND bn.letter = '".$letter."'";
			}
			if($cid && $letter)
			{
				$where = " AND b.cateid = ".$cid." AND b.letter = '".$letter."'";
				$where2 = " AND bn.cateid = ".$cid." AND bn.letter = '".$letter."'";
			}
			if($mid)
			{
				$sql = 'SELECT count(*) as num FROM merchants AS m INNER JOIN brand AS b ON b.merchantsId = m.id INNER JOIN brand_name AS bn ON bn.id = b.brand_name_id left join brand_cate as bc on bc.id = bn.cateid WHERE b.end_time > '.time().' and m.id = '.$mid.$where2;
				$row = $this->query ( $sql );
				$pageCore->count = $row [0] ['num'];
				$pageCore->pageCount = ceil ( $pageCore->count / $pageCore->pageSize );
				$sql = 'SELECT bn.zhekou as bn_zhekou, bn.id AS bn_id, bn. NAME AS bn_name, bn.image AS bn_image, bn.name AS bc_name, m. NAME AS m_name, m.id AS m_id, b.url AS b_url,b.rebate as b_rebate,b.maxrebate as b_maxrebate FROM merchants AS m INNER JOIN brand AS b ON b.merchantsId = m.id INNER JOIN brand_name AS bn ON bn.id = b.brand_name_id left join brand_cate as bc on bc.id = bn.cateid WHERE  b.end_time > '.time().' and m.id = '.$mid.$where2.' order by b.sort desc, b.id desc';
			}else{
				$sql = 'SELECT count(*) as num FROM brand_name AS b INNER JOIN brand_cate AS bc ON bc.id = b.cateid JOIN brand as brand on brand.brand_name_id = b.id where brand.end_time > '.time().' and brand.state = 1 '.$where;
				$row = $this->query ( $sql );
				$pageCore->count = $row [0] ['num'];
				$pageCore->pageCount = ceil ( $pageCore->count / $pageCore->pageSize );
				$sql = 'SELECT bn.zhekou as bn_zhekou,bn.id AS bn_id, bn. NAME AS bn_name, bn.image AS bn_image, bn.bc_name AS bc_name, m. NAME AS m_name, m.id AS m_id, b.url AS b_url,b.rebate as b_rebate, b.maxrebate as b_maxrebate FROM ( SELECT b.*, bc.id AS bc_id, bc.`name` AS bc_name FROM brand_name AS b INNER JOIN brand_cate AS bc ON bc.id = b.cateid JOIN brand as brand on brand.brand_name_id = b.id where brand.end_time > '.time().' AND brand.state = 1 '.$where.' order by brand.sort desc, brand.id desc  LIMIT  '.($pageCore->currentPage - 1) * $pageCore->pageSize . ',' . $pageCore->pageSize.' ) AS bn INNER JOIN brand AS b ON b.brand_name_id = bn.id INNER JOIN merchants AS m ON m.id = b.merchantsId where b.state = 1 AND b.end_time > '.time().' order by b.sort desc, b.id desc';
			}	
		}	
		$statement = $this->run($sql);
		$brandModels = array();
		while ($result = $statement->fetch(PDO::FETCH_ASSOC))
		{
			//P($result);
			$bn_id = $result['bn_id'];
			if (empty($brandModels[$bn_id]))
			{
				$brandModel = new BrandnameDataModel();
				$brandModel->maxrebate = $result['b_maxrebate'];
				$brandModel->rebate = $result['b_rebate'];
				$brandModel->name = $result['bn_name'];
				$brandModel->image = $result['bn_image'];
				$brandModel->url = $result['b_url'];
				$brandModel->zhekou = $result['bn_zhekou'];
				$brandModels[$bn_id] = $brandModel;
			}
			if (isset($result['m_id']))
			{
				$merchantsModel = new MerchantsDataModel();
				foreach ($merchantsModel as $key => $val) 
				{
					if (isset($result['m_' . $key]))
					{
						$merchantsModel->$key = $result['m_' . $key];
					}
				}
				$merchantsModel-> b_rebate = $result['b_rebate'];
				$merchantsModel->b_url = $result['b_url'];
				//$brandModels[$bn_id]->$brandModel->total = count();
				$brandModels[$bn_id]->shangjia[$merchantsModel->id] = $merchantsModel;
			}
			$brandModels[$bn_id]->total = count($brandModels[$bn_id]->shangjia);
		}
		
		//P(count($brandModels));
		//P($brandModels);exit;
		return $brandModels;
	}
	
	//前台兼职编辑
	public function getOne($id)
	{
	
		$sql = 'SELECT t1.*, t2.username AS username,t3.name as bn_name,t4.name as m_name FROM brand AS t1 JOIN brandadmin AS t2 ON t2.id = t1.userid JOIN brand_name as t3 on t3.id = t1.brand_name_id JOIN merchants as t4 on t4.id = t1.merchantsId where t1.userid = ' .$_COOKIE['brand_id'] .' AND t1.id = '.$id;

		$brandData = $this->query($sql,'BrandDataModel');
		$brandData = array_pop($brandData);
		return $brandData;
	}
	//后台编辑
	public function getOne2($id)
	{
	
		$sql = 'SELECT t1.*, t2.username AS username,t3.name as bn_name,t4.name as m_name FROM brand AS t1 left JOIN brandadmin AS t2 ON t2.id = t1.userid JOIN brand_name as t3 on t3.id = t1.brand_name_id JOIN merchants as t4 on t4.id = t1.merchantsId where t1.id = '.$id;

		$brandData = $this->query($sql,'BrandDataModel');
		$brandData = array_pop($brandData);
		return $brandData;
	}
	
	public function delMsg($id)
	{
		$ids = is_array($id) ? $id : array($id);
		$sql = 'delete from brand where id in ('.implode(',', $ids).')';
		$this->exec($sql);
	}
	
	/**
	 * 改变商品状态
	 * @param array $ids 商品ID
	 * @param int $state 状态值
	 */
	public function changeState($ids,$state)
	{
		$user = json_decode($_COOKIE['UserInfo']);
		$name = $user->UserName;
		$sql = 'update brand set state='.$state.' , createtime = '.time().' , audit = '."'$name'".' where id in ('.implode(',',$ids).')';
		$this->exec($sql);
	}
	
	public function getOneByUrl($url)
	{
		$this->where(array('url'=>$url));
		return $this->findOne();
	}
}

