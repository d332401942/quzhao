<?php

class UserData extends BaseData
{
	public function addUser($arr)
	{
		$result = $this->add($arr);
		return $result;
	}

}
