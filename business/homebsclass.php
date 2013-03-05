<?php


/**
 * 合作商家分类
 * @author Administrator
 *
 */
class HomeBsClassBusiness extends BaseBusiness
{
	
	public function add($model)
	{
		$data = new HomeBsClassData();
		$data->add($model);
	}
	
	public function findAll()
	{
		$data = new HomeBsClassData();
		$data->setOrder(array('sort' => 'desc'));
		$result = $data->findAll();
		return $result;
	}
	
	public function del($id)
	{
		$data = new HomeBsClassData();
		$data->delById($id);
	}
}