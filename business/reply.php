<?php

class ReplyBusiness extends BaseBusiness
{
	
    public function add($model)
	{
		$data = new ReplyData();
		$data->addReply($model);
	}
	
	/*
	*删除回复
	*/
	public function deleteReply($ids,$userid)
	{
		$data = new ReplyData();
		$data->delRely($ids,$userid);
	}
}
