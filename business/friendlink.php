<?php

class FriendLinkBusiness extends BaseBusiness
{
	
	public function add($model)
	{
		$data = M('FriendLinkData');
		$data->add($model);
	}

	public function delById($id)
	{
		$data = M('FriendLinkData');
		$data->delById($id);
	}

	public function findAll()
	{
		$data = M('FriendLinkData');
		$data->setOrder(array('sort' => 'desc'));
		return $data->findAll();
	}
}
