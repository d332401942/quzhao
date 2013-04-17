<?php

class UserData extends BaseData
{
	public function addUser($model)
	{
		$this->add($model);
	}
	
	public function checkuser($name){
		$this->where(array('email'=>array('='=>$name)));
		$result = $this->findAll();
		return $result;
	}

}
