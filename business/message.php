<?php

class MessageBusiness extends BaseBusiness
{
	
    public function add($model)
	{
		$data = new MessageData();
		$data->addMsg($model);
	}
	
	public function findAll($pageCore,$pid,$isLastPage)
	{
		$data = new MessageData();
		$result = $data->getAll($pageCore,$pid,$isLastPage);
		return $result;
	}
}
