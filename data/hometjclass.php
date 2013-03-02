<?php

class HomeTjClassData extends BaseData
{
	
	/**
	 * 得到根分类的数据
	 */
	public function getRootClass()
	{
		$query = array('pid' => 0);
		$this->where($query);
		$models = $this->findAll();
		return $models;
	}
	
}