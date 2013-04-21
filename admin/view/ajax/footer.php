<?php

class FooterAjaxView extends BaseAjaxView
{
    
    public function del()
    {
        $id = (int)$_POST['id'];
        $business = new FooterBusiness();
        $business->del($id);
        $this->response(true);
    }
}