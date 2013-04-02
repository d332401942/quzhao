<?php

class endDpView extends BaseView
{
    public function index($parameters)
    {
        $this->setMeta();
        $business = new HomeTjDataBusiness();
       //得到推荐产品
        $tjModels = $business->getTjDpModels(5);
        //得到产品详细
        $goods = $business->getOneById($parameters['id']);
       //得到产品商家
        $comefrom = new NetDataSourceBusiness();
        $fid = $comefrom->getOneById($goods->fid);
        //推荐用户名
        $editorArr = array(
			'珞邪',
			'夏天爱清新',
			'TomaTo迷离 ',
			'生如夏花之灿烂 ',
			'McQueen的時光記事本',
			'桃子_miko',
			'小怪兽s',
			'妙妙辛',
			'没囿紅色的紅色', 
			'Miss_mario',
			'一个太阳一朶向日葵',
			'小小漫m丶',
			'LNP蓝风',
			'袋鼠康康',
			'斯图彼得猫',
			'天魔霸邪',
			'唐朝秀才郎',
			'木木-lol',
			'黑夜里的网子',
			'小家伙的足迹',
			'尐黑妞Serena',
			'雨后巴黎小小温情', 
			'喊我33就很好',
			'泡芙小米粒',
			'皮蛋兔肉粥',
			'单小V_V',
			'糊大人cocoa',
		);
		$this->assign('editorArr', $editorArr);
        $this->assign('tjModels', $tjModels);
        $this->assign('goods', $goods);
        $this->assign('fid', $fid);
    }
}
?>