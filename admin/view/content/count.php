<?php 

class CountContentView extends BaseView
{
	public function index()
	{
		$isPart = 0;
		if(!empty($_GET['cate']) && (int)$_GET['cate'])
		{
			$isPart = (int)$_GET['cate'];
		}
		
		$strtime = null;
		if(!empty($_GET['time_start']))
		{
			$strtime = $_GET['time_start'];
		}
		
		$endtime = null;
		if(!empty($_GET['time_end']))
		{
			$endtime = $_GET['time_end'];
		}
		
		/*
		 *得到数据数目
		 */
		$business = new HomeTjDataBusiness();
		$totalNum = $business->getDayNumber($cate, $strtime, $endtime, 0);
		$totalNumTrue = $business->getDayNumber($cate, $strtime, $endtime, 1);
		$totalNumFalse = $business->getDayNumber($cate, $strtime, $endtime, 2);
		
		/*
		 *合并查询结果
		 */
		foreach($totalNum as $key=>$total)
		{
			foreach($totalNumTrue as $numT)
			{
				if($total['id'] == $numT['id'])
				{
					$totalNum[$key]['numTrue'] = $numT['num']; 
				}
				else
				{
					$totalNum[$key]['numTrue'] = 0; 
				}
			}
			foreach($totalNumFalse as $numF)
			{
				if($total['id'] == $numF['id'])
				{
					$totalNum[$key]['numFalse'] = $numF['num']; 
				}
				else
				{
					$totalNum[$key]['numFalse'] = 0;
				}
			}
		}
		/**
		 * 日期插件
		 */
		$dateFrom = FormCommon::date('time_start',date('Y-m-d H:i:s'),true);
		$dateTo = FormCommon::date('time_end',date('Y-m-d H:i:s'),true);
		$this->assign('dateTo', $dateTo);
		$this->assign('dateFrom', $dateFrom);
		
		$this->assign('totalNum', $totalNum);
		$this->assign('title', '商品统计');
	}
}