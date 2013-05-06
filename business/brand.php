<?php
class BrandBusiness extends BaseBusiness
{
	public function add($model)
	{
		$data = M('BrandData');
		$data->add($model);
	}
	
	public function update($model)
	{
		$data = M('BrandData');
		$data->updateModel($model);
	}
	/*
	*兼职个人列表
	*/
	public function getAll($pageCore)
	{
		$data = M('BrandData');
		return $data->getAll($pageCore);
	}
	/*
	*前台调用所有的
	*/
	public function getAll2($pageCore,$cid,$letter,$mid,$num)
	{
		$data = M('BrandData');
		return $data->getAll2($pageCore,$cid,$letter,$mid,$num);
	}
	
	/*
	*后台调用所有的
	*/
	public function getAll3($pageCore,$state,$id)
	{
		$data = M('BrandData');
		return $data->getAll3($pageCore,$state,$id);
	}
	/*
	*删除
	*/
	public function deleteBrand($ids)
	{
		$data = new BrandData();
		$data->delMsg($ids);
	}
	
	public function getOneId($id)
	{
		$data = new BrandData();
		return $data->getOne($id);
	}
	//后台编辑数据
	public function getOneId2($id)
	{
		$data = new BrandData();
		return $data->getOne2($id);
	}
	
	/*
	*检测品牌商家是否已经存在
	*	brandid 品牌id
	*	sjid	商家id
	*/
	public function check($brandid,$sjid)
	{
		$data = new BrandData();
		$sql = 'select * from brand where brand_name_id = '.$brandid.' AND merchantsId = '.$sjid;
		return $data->query($sql);
	}
	
	 public function changeState($ids, $state)
    {
        if (empty($ids))
        {
            $this->throwException('商品id不能为空');
        }
		$data = new BrandData();
        $data->changeState($ids, $state);
    }
	
	//得到发布次数
	public function getAllTotal($userid = false,$strTime = false,$endTiem =false,$yueStr = false,$yueEnd =false)
	{
		if($userid)
		{
			$data = new BrandData();
			$sql = 'select count(*) as num from brand where userid = '. $userid;
			if($yueStr && $yueEnd)
			{
				$sql = 'select count(*) as num from brand where userid = '. $userid.' AND createtime > '.$yueStr.' && createtime < '.$yueEnd;
			}else if($strTime && $endTiem){
				$sql = 'select count(*) as num from brand where userid = '. $userid.' AND createtime > '.$strTime.' && createtime < '.$endTiem;
			}else{
				$sql = 'select count(*) as num from brand where userid = '. $userid;
			}
			$total = $data->query($sql);
			return $total[0]['num'];
		}	
	}
	
	//得到已通过发布次数
	public function tgCount($userid = false,$strTime = false,$endTiem =false,$yueStr = false,$yueEnd =false)
	{
		if($userid)
		{
			$data = new BrandData();
			if($yueStr && $yueEnd)
			{
				$sql = 'select count(*) as num from brand where  state in(1,6) AND userid = '. $userid.' AND createtime > '.$yueStr.' && createtime < '.$yueEnd;
			}else if($strTime && $endTiem){
				$sql = 'select count(*) as num from brand where  state in(1,6) AND  userid = '. $userid.' AND createtime > '.$strTime.' && createtime < '.$endTiem;
			}else{
				$sql = 'select count(*) as num from brand where  state in(1,6) AND userid = '. $userid;
			}
			$total = $data->query($sql);
			return $total[0]['num'];
		}	
	}
	
}

?>