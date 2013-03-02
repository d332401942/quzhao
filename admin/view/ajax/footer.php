<?php

class FooterAjaxView extends AjaxCoreLib
{
    
    public function del()
    {
        $id = (int)$_POST['id'];
        $business = new FooterBusiness();
        $business->del($id);
        $this->response(true);
    }
}