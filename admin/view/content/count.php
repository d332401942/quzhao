<?php 

class CountContentView extends BaseView
{
	public function index()
	{
		$cate = null;
		if(!empty($_GET['cate']) && (int)$_GET['cate'])
		{
			$cate = $_GET['cate'];
		}
		
		/*
		 *得到今天总数据
		 */
		$business = M('HomeTjDataBusiness');
		$totalNum = $business->getDayNumber($cate);
		/*
		 *得到今天已通过总数据
		 */
		$totalNumTrue = $business->getDayNumberTrue($cate);
		/*
		 *得到今天未通过总数据
		 */
		$totalNumFalse = $business->getDayNumberFalse($cate);
		$this->assign('totalNum', $totalNum);
		$this->assign('totalNumTrue', $totalNumTrue);
		$this->assign('totalNumFalse', $totalNumFalse);
		$this->assign('title', '商品统计');
	}
}