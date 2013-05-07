<?php

class AssociatedBusiness extends BaseBusiness
{
	
    public function add($model)
	{
		$data = new ReplyData();
		$data->addReply($model);
	}
	
	/*
	*查询关键词
	*/
	public function getAll($pageCore,$name)
	{
		$data = new AssociatedData();
		return $data->getAll($pageCore,$name);
	}
}
