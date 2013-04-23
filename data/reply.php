<?php

class ReplyData extends BaseData
{

	public function addReply($model)
	{
		$this->add ( $model );
	}
	
	public function delRely($id,$userid=false)
	{
		
		$sql = 'delete from reply where id = '.$id.' AND userid = '.$userid;
		$this->exec($sql);
	}
}
