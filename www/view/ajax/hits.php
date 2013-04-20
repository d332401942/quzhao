<?php

class HitsAjaxView extends BaseAjaxView
{
    
    public function log()
    {
        $model = new HitsDataModel();
        if (empty($_GET['id']) || empty($_GET['type']))
        {
            return;
        }
        $id = (int)$_GET['id'];
        $type = (int)$_GET['type'];
        $model->data_id = $id;
        $model->type = $type;
        $model->time = time();
        $model->ip = ip2long($_SERVER['REMOTE_ADDR']);
        $model->user_id = 0;
        $business = new HitsBusiness();
        $business->add($model);
        $this->response(true);
    }
}
