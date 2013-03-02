<?php 

class HomeBsDataBusiness extends BaseBusiness
{
	
	public function add($model)
	{
		if (!$model->bid)
		{
			$this->throwException('没有选择分类');
		}
		if (!$model->name)
		{
			$this->throwException('没有填写名称');
		}
		if (!$model->href)
		{
			$this->throwException('没有填写商家连接');
		}
		$data = new HomeBsDataData();
		$data->add($model);
	}
    
    public function updateByModel($model)
    {
        $data = new HomeBsDataData();
        $data->updateModel($model);
    }
	
    public function getOneById($id)
    {
        $data = new HomeBsDataData();
        return $data->getOneById($id);
    }
	
	public function findAll()
	{
		$data = new HomeBsDataData();
		$data->setOrder(array('sort' => 'desc'));
		return $data->findAll();
	}
	
	public function del($id)
	{
		$data = new HomeBsDataData();
		$data->delById($id);
	}
	
	/**
	 * 得到热门商家数据
	 */
	public function getHomeBsModels()
	{
		$data = new HomeBsDataData();
		return $data->getHomeBsModels();
	}
    
    public function updateClassSort($id,$value)
    {
        $data = new HomeBsClassData();
        $data->updateClassSort($id,$value);
    }
    
    public function updateClassName($id,$value)
    {
        $data = new HomeBsClassData();
        $data->updateClassName($id,$value);
    }
}