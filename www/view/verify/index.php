<?php 
class IndexVerifyView extends BaseView
{
    public function __construct()
    {
        parent::__construct(false);
    }
    
    public function index()
    {
        $verify = new VerifyUtilLib();
        ob_clean();
        echo $verify;
        exit;
    }
}