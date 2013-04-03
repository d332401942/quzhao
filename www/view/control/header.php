<?php

class HeaderControlView extends BaseView
{

    public function index($parameters)
    {
        $menu = new NavmenuModel();
        $this->assign('meta', $parameters['meta']);
        $this->assign('menu', $menu);

        $css = empty($parameters['css']) ? array() : explode(',', $parameters['css']);
        $this->assign('css', $css);

        $js = empty($parameters['js']) ? array() : explode(',', $parameters['js']);
        $this->assign('js', $js);

        $type = empty($parameters['type']) ? null : trim($parameters['type']);
        $this->assign('type', $type);

        $keyword = empty($parameters['keyword']) ? null : trim($parameters['keyword']);
        if (empty($keyword))
        {
            $keyword = '羽绒服';
        }
       
        //得到分类信息
        $this->classModels = $this->getClassModels();
        $this->assign('classModels',$this->classModels);
        $this->assign('keyword', $keyword);
    }
    
    private function getClassModels()
	{
		$business = new NetTuanBusiness();
		$models = $business->getAllClassModels();
		return $models;
	}
    

}