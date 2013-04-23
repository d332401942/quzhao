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
	/*
	*查询出所有评论后台管理
	*/
	public function findAllMessage($pageCore)
	{
		$data = new MessageData();
		$result = $data->getMessageAll($pageCore);
		return $result;
	}
	
	/*
	*删除评论
	*/
	public function deleteMessage($ids)
	{
		$data = new MessageData();
		$data->delMsg($ids);
	}
	
	public function getMsgOne($id)
	{	
		$data = new MessageData();
		return $data->getOneById($id);
	}
}
