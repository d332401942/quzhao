<?php

class ReplyBusiness extends BaseBusiness
{
	
    public function add($model)
	{
		$data = new ReplyData();
		$data->addReply($model);
	}
}
