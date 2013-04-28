<?php

class HitsBusiness extends BaseBusiness
{
    
	const TYPE_NINE = 1;

    public function add($model)
    {
        $data = new HitsData();
        $data->add($model);
    }

	public function getHits($pageCore, $type, $time = 86400, $dataId = null,$cid)
	{
		$data = M('HitsData');
		$function = null;
		if ($type == self::TYPE_NINE)
		{
			$function = 'getNineHits';
		}
		$models = $data->$function($pageCore, $time, $dataId,$cid);
		return $models;
	}
}
