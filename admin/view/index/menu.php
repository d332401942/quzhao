<?php

class MenuIndexView extends BaseView
{
    
    public function index()
    {
        $menu = array(
            array('name' => '用户','url' => 'left/user'),
            array('name' => '文章','url' => '../'),
            array('name' => '类别','url' => '../'),
        );
        
        $this->assign('menu',$menu);
    }
}