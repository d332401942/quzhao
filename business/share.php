<?php

class ShareBusiness extends BaseBusiness
{
    public function addShare($model)
    {
		$data = new ShareData();
		$data->add($model);
    }
}
