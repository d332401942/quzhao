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
        array_unshift($js, 'jquery.mask');
        array_unshift($js, 'jquery.form');
        array_unshift($js, 'jquery.cookie');
        array_unshift($js, 'jquery');
        $js = array_unique($js);
        $this->assign('js', $js);

        $type = empty($parameters['type']) ? null : trim($parameters['type']);
        $this->assign('type', $type);

        $keyword = empty($parameters['keyword']) ? null : trim($parameters['keyword']);
        if (empty($keyword))
        {
            $keyword = '电饭煲';
        }
        $this->assign('keyword', $keyword);
    }
}