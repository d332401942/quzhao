<?php 

class HomeBrandAdBusiness extends BaseBusiness
{
	
	public function add($model)
	{
		$data = new HomeBrandAdData();
		$data->add($model);
	}
	
	public function updateModel($model)
	{
		$data = new HomeBrandAdData();
		$data->updateModel($model);
	}
	
	public function del($id)
	{
		$data = new HomeBrandAdData();
		$data->delById($id);
	}
	
	public function getOneById($id)
	{
		$data = new HomeBrandAdData();
		return $data->getOneById($id);
	}
	
	public function getHomeBrandAdModels($stype = array())
	{
		$data = new HomeBrandAdData();
		if ($stype)
		{
			$data->where(array('stype' => array('in' => $stype)));
		}
		$data->setOrder(array('sort' => 'desc', 'id' => 'desc'));
		return $data->findAll();
	}
	
	public function findAll($pageCore,$stype = null)
	{
		$data = new HomeBrandAdData();
		$data->setPage($pageCore);
		$query = array();
		if ($stype !== null)
		{
			$query['stype'] = $stype;
		}
		
		if ($query)
		{
			$data->where($query);
		}
		
		$data->setOrder(array('sort' => 'desc', 'id' => 'desc'));
		return $data->findAll();
	}
}