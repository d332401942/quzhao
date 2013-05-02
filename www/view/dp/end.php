<?php

class endDpView extends BaseView
{
    public function index($parameters)
    {
        $id = !empty($parameters)?intval($parameters['id']):'';
        $business = new HomeTjDataBusiness();
       //得到推荐产品
        $tjModels = $business->getTjDpModels(5);
        //得到产品详细
        $goods = $business->getOneById($id);
		if(empty($goods))
		{
			$this->responseError('404');
		}
		$model = null;
		$goods = array_pop($goods);
		if($goods)
		{
			//得到产品商家
			$comefrom = new NetDataSourceBusiness();
			$fromSiteName = $comefrom->getFromSiteName($goods->href);
			//$model = $comefrom->getOneById($goods->fid);
		}
       //得到大家都喜欢
	   $loveModel = $business->getLoveModel();
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
		//新浪微博appKey
		$sina = new ConnectModel();
		$this->setMeta($goods->name. '_趣找购物搜索');
		$this->assign('sinaApp',$sina->appIdWeibo);
		$this->assign('editorArr', $editorArr);
        $this->assign('tjModels', $tjModels);
        $this->assign('goods', $goods);
        $this->assign('fromSiteName', $fromSiteName);
		$this->assign('id', $id);
		$this->assign('loveModel', $loveModel);
    }
}
?>