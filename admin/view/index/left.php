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
                    'url' => 'homebrand/lists',
                ),
				array(
                    'name' => '添加品牌',
                    'url' => 'homebrand/brand'
                ),
				array(
                    'name' => '品牌管理',
                    'url' => 'homebrand/editbrand'
                ),
				array(
					'name' => '商家添加',
					'url' => 'merchants/add',
				),
				array(
					'name' => '分类添加',
					'url' => 'category/cateadd',
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

			'商品点击统计' => array(
				array(
					'name' => '9.9包邮',
					'url' => 'hits/nine',
				),
				array(
					'name' => '超值单品',
					'url' => 'hits/nine__cid/2',
				),
				array(
					'name' => '关键词统计',
					'url' => 'keywords/index',
				)
			),
			
			'会员管理' => array(
				array(
					'name' => '会员列表',
					'url' => 'user/list',		
				),
				array(
					'name' => '优惠商品',
					'url' => 'user/share',
				),
				array(
					'name' => '折扣活动',
					'url' => '',
				),
			),
			'评论管理' => array(
				array(
					'name' => '评论查看',
					'url' => 'message/show',
				)
			),
			
			'兼职管理' => array(
				array(
					'name' => '超值单品',
					'url' => 'temp/index',
				)
			),
			
        );
        $this->assign('menu', $menu);
    }

}
