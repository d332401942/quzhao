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
        //得到热门的关键词
        $business = M('AssociatedBusiness');
        $keywordArr = array(
        				'手机',
        				'电风扇',
        				'USB风扇',
        				'凉席',
        				'凉鞋',
        				
        );
        $defkeyword = $keywordArr[mt_rand(0, count($keywordArr) - 1)];
        if (empty($keyword))
        {
            $keyword = $defkeyword;
        }
        $this->assign('defKeyword', $defkeyword);
        $this->assign('keyword', $keyword);
    }
}