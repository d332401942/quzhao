<?php

class UserAjaxView extends AjaxCoreLib
{

    public function loginOut()
    {
        setcookie('UserInfo', '', -1,'/');
        $this->response(true);
    }

}

