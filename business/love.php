<?php

class LoveBusiness extends BaseBusiness
{
    public function add($model)
	{
		$data = new LoveData();
		$data->add($model);
	}
	/*
	*查看该会员是不是喜欢过该产品
	*/
	public function getLove($pid,$userid)
	{
		$data = new LoveData();
		$query = array();
		$query['home_tj_data_id'] = $pid;
		$query['userid']		  = $userid;	
		$data->where($query);
		$result = $data->findOne();
		return $result;
	}
}
