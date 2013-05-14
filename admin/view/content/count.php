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
		
		$strtime = null;
		if(!empty($_GET['strtime']) && (int)$_GET['strtime'])
		{
			$strtime = $_GET['strtime'];
		}
		
		$endtime = null;
		if(!empty($_GET['endtime']) && (int)$_GET['endtime'])
		{
			$endtime = $_GET['endtime'];
		}
		/*
		 *得到今天总数据
		 */
		$business = M('HomeTjDataBusiness');
		$totalNum = $business->getDayNumber($cate, $strtime, $endtime);
		/*
		 *得到今天已通过总数据
		 */
		$totalNumTrue = $business->getDayNumberTrue($cate, $strtime, $endtime);
		/*
		 *得到今天未通过总数据
		 */
		$totalNumFalse = $business->getDayNumberFalse($cate, $strtime, $endtime);
		$this->assign('totalNum', $totalNum);
		$this->assign('totalNumTrue', $totalNumTrue);
		$this->assign('totalNumFalse', $totalNumFalse);
		$this->assign('title', '商品统计');
	}
}