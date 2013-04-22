<?php

class BaseDataModel extends ModelCoreLib
{

	const SEX_TYPE_MAN = 1;
	
	const SEX_TYPE_WOMAN = 2;
	
	const SEX_TYPE_UNDEFINED = 3;
	
    public $id;

    public function __construct()
    {
        $this->setPrimaryKey('id');
        parent::__construct();
    }
}