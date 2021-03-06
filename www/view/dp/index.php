<?php

class IndexDpView extends BaseView
{

	public function Index($parameters)
	{
        $cid = isset($parameters['cid']) ? intval($parameters['cid']) : '';
		$this->setMeta('超值单品_趣找购物搜索');
		// 得到超值单品的数据
		$business = new HomeTjDataBusiness();
        $pageCore = new PageCoreLib();
        $pageCore->currentPage = !empty($parameters['page']) ? (int)$parameters['page'] : 1;
        $pageCore->currentPage = $pageCore->currentPage ? $pageCore->currentPage : 1;
        $pageCore->pageSize = 16;
		$models = $business->getDp($pageCore,$cid);
		//得到推荐的单品
		$tjModels = $business->getTjDpModels(5);
		//得到历史记录
		$dpBrowseHistoryModels = $this->dpBrowseHistoryModels();
        
        //得到超值单品分类
        $business = new HomeTjClassBusiness();
        $modelCate = $business->getAllDp();
		$count = count($modelCate);
		for($i=0;$i<$count;$i++){
			$modelCate[$i]->classid = $i+1;
		}
		//新浪微博appKey
		$sina = new ConnectModel();
		$this->assign('sinaApp',$sina->appIdWeibo);
		$this->assign('cid', $cid);
        $this->assign('modelCate', $modelCate);
		$this->assign('models', $models);
		$this->assign('tjModels', $tjModels);
		$this->assign('dpBrowseHistoryModels', $dpBrowseHistoryModels);
        $this->assign('pageCore',$pageCore);
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
	}
	
	private function dpBrowseHistoryModels()
	{
		if (empty($_COOKIE['dpBrowseLog']))
		{
			return array();
		}
		$ids = $_COOKIE['dpBrowseLog'];
		$arrIds = explode(',',$ids);
		$business = new HomeTjDataBusiness();
		$models = $business->dpBrowseHistoryModels($arrIds);
		$models = $models ? $models : array();
		return $models;
	}
}