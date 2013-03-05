<?php

class FooterData extends BaseData
{
    public function findTitle()
    {
        $sql = 'select title,id from footer order by sort';
        $models = $this->query($sql,'FooterDataModel');
        return $models;
    }
}
