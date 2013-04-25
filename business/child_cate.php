<?php
class Child_cateBusiness extends BaseBusiness
{
	public function getAll($cateid)
	{
		$data = M('Child_cateData');
		$data->setOrder(array('id'=>'desc'));
		$data->where(array('brand_cate_id'=>array('='=>$cateid)));
		return $data->findAll();
	}
}

?>