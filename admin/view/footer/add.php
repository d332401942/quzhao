<?php
/**
 * 页脚栏目设置
 * @author Administrator
 */
class AddFooterView extends BaseView
{
    public function index()
    {
        $this->assign('title', '页脚栏目');
        if ($_POST)
        {
            $this->add();
        }
        $id = null;
        if (!empty($_GET['id']))
        {
            $id = (int)$_GET['id'];
        }
        $business = new FooterBusiness();
        $model = $business->getOneById($id);
        if (!$model)
        {
            $model = new FooterDataModel();
        }
        $editor = FormCommon::editor('content',  FormCommon::EDIT_THEME_FULL);
        $this->assign('editor', $editor);
        $this->assign('model', $model);
    }
    
    private function add()
    {
        $model = new FooterDataModel();
        $model->title = $_POST['title'];
        $model->content = $_POST['content'];
        $model->sort = (int)$_POST['sort'];
        $business = new FooterBusiness;
        if (!empty($_POST['id']))
        {
            $model->id = (int)$_POST['id'];
            $business->updateByModel($model);
        }
        else
        {
            $business->add($model);
        }
    }
}
