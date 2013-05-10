<?php

class LoveBusiness extends BaseBusiness
{
    public function add($model)
	{
		$data = new LoveData();
		$data->add($model);
	}
	/**
	*查看该会员是不是喜欢过该产品
	*/
	public function getLove($pid,$userid,$type = LoveDataModel::LOVE_TYPE_HOME_TJ_DATA)
	{
		new LoveDataModel();
		$data = new LoveData();
		$query = array();
		$query['home_tj_data_id'] = $pid;
		$query['userid']		  = $userid;
		$query['loveType']		  = $type;
		$data->where($query);
		$result = $data->findOne();
		return $result;
	}
	
	/**
	 * 取消喜欢
	 * @param unknown $loveModel
	 */
	public function delLove($loveModel)
	{
		$data = new LoveData();
		$homeTjDataBusiness = new HomeTjDataBusiness();
		$data->delById($loveModel->id);
	}
}
