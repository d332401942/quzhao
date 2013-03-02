<?php

class HitsBusiness extends BaseBusiness
{
    
    public function add($model)
    {
        $data = new HitsData();
        $data->add($model);
    }
}