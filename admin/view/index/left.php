<?php

class LeftIndexView extends BaseView
{

    public function index()
    {
        $menu = array(
            '内容管理' => array(
                array(
                    'name' => '内容列表',
                    'url' => 'content'
                ),
                array(
                    'name' => '新建类容',
                    'url' => 'content/add'
                ),
                array(
                    'name' => '类别管理',
                    'url' => 'tjclass'
                ),
                array(
                    'name' => '备选库',
                    'url' => 'netdata'
                ),
            ),
            '热门商家' => array(
                array(
                    'name' => '列表',
                    'url' => 'homebs'
                ),
                array(
                    'name' => '新增',
                    'url' => 'homebs/add'
                ),
                array(
                    'name' => '商家分类',
                    'url' => 'homebs/class'
                ),
            ),
            '品牌特卖' => array(
                array(
                    'name' => '品牌列表',
                    'url' => 'homebrand',
                ),
                array(
                    'name' => '添加品牌',
                    'url' => 'homebrand/add'
                ),
                array(
                    'name' => '品牌推荐',
                    'url' => 'homebrand/data'
                ),
                array(
                    'name' => '添加推荐',
                    'url' => 'homebrand/dataadd'
                ),
            ),
            '广告管理' => array(
                array(
                    'name' => '广告列表',
                    'url' => 'homebrandad'
                ),
                array(
                    'name' => '添加广告',
                    'url' => 'homebrandad/add'
                ),
            ),
            '团购' => array(
                array(
                    'name' => '团购',
                    'url' => 'tuan'
                ),
                array(
                    'name' => '首页内容',
                    'url' => 'tuan/recommend'
                ),
            ),
            '页脚内容' => array(
                array(
                    'name' => '栏目',
                    'url' => 'footer'
                ),
                array(
                    'name' => '添加',
                    'url' => 'footer/add'
                ),
            ),
			'友情链接' => array(
				array(
					'name' => '列表',
					'url' => 'friendlink',
				),
				array(
					'name' => '添加',
					'url' => 'friendlink/add',
				),

			),
        );
        $this->assign('menu', $menu);
    }

}
