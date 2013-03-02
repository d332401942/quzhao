<?php
class MsgIndexView extends BaseView
{
    public function __construct()
    {
        parent::__construct(false);
    }
    
    public function index()
    {
        $msg = !empty($_GET['msg']) ? urldecode($_GET['msg']) : null;
        $url = !empty($_GET['url']) ? urldecode($_GET['url']) : $_SERVER['HTTP_REFERER'];
        $mark = true;
        if (isset($_GET['mark']) && $_GET['mark'] == 0) 
        {
        	$mark = false;
        }
        $this->assign('msg', $msg);
        $this->assign('mark',$mark);
        $this->assign('timeout',3);
        $this->assign('url',$url);
    }
}