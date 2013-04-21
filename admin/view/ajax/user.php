<?php

class UserAjaxView extends BaseAjaxView
{

    public function loginOut()
    {
        setcookie('UserInfo', '', -1,'/');
        $this->response(true);
    }

}

