<?php

class TopIndexView extends BaseView
{

    public function Index()
    {
        $this->assign('userName',$this->userInfo->UserName);
    }

}