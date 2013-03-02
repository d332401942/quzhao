<?php

class NavmenuModel extends Feng
{
    
    const MENU_NINE = 'nine';
    
    const MENU_DB = 'dp';
    
    const MENU_BRAND = 'brand';
    
    const MENU_TUAN = 'tuan';
    
    const MENU_BBS = 'bbs';
    
    public $menu = array();
    
    public function __construct()
    {
        $this->menu[self::MENU_NINE] = array('name' => '9.9包邮', 'url' => APP_URL.'/nine', 'image' => 'nav_1.gif', 'target' => '_self');
        $this->menu[self::MENU_DB] = array('name' => '超值单品', 'url' => APP_URL.'/dp', 'image' => 'nav_2.gif', 'target' => '_self');
        $this->menu[self::MENU_BRAND] = array('name' => '品牌特卖', 'url' => APP_URL.'/brand', 'image' => 'nav_3.gif', 'target' => '_self');
        $this->menu[self::MENU_TUAN] = array('name' => '精品团购', 'url' => APP_URL . '/tuan', 'image' => 'nav_4.gif', 'target' => '_self');
        $this->menu[self::MENU_BBS] = array('name' => '社区', 'url' => APP_URL . 'http://bbs.quzhao.com', 'image' => 'nav_5.gif', 'target' => '_blank');
    }
}