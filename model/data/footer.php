<?php

class FooterDataModel extends BaseDataModel
{
    
    public $title;
    
    public $content;
    
    public $sort;
    
    public function __construct()
    {
        parent::__construct();
        $this->setTableName('footer');
    }
}
