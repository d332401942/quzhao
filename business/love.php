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
	public function getLove($userid)
	{
		$data = new LoveData();
		$data->where(array('userid'=>$userid));
		$result = $data->findOne();
		return $result;
	}
}
