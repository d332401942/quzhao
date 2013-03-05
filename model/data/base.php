<?php

class BaseDataModel extends ModelCoreLib
{

    public $id;

    public function __construct()
    {
        $this->setPrimaryKey('id');
        parent::__construct();
    }
}