<?php

class DemoIndexView extends BaseView
{

    public function Index()
    {
        phpinfo();
        $this->assign('name', '缓冲测试');
        $rely = rand(0,5);
        $this->cache('initCacheData',$rely,10);
    }


    public function initCacheData()
    {
        FB::log(123);
        $data = array(1, 2, 34, 5);
        $this->assign('data', $data);
        
    }

}
