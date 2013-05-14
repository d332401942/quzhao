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
		if(!empty($_GET['strtime']))
		{
			$strtime = $_GET['strtime'];
		}
		
		$endtime = null;
		if(!empty($_GET['endtime']))
		{
			$endtime = $_GET['endtime'];
		}
		
		/*
		 *得到今天总数据
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
					$totalNum[$key]['num2'] = $numT['num2']; 
				}
				else
				{
					$totalNum[$key]['num2'] = 0; 
				}
			}
			foreach($totalNumFalse as $numF)
			{
				if($total['id'] == $numF['id'])
				{
					$totalNum[$key]['num3'] = $numF['num3']; 
				}
				else
				{
					$totalNum[$key]['num3'] = 0;
				}
			}
		}
		$this->assign('totalNum', $totalNum);
		$this->assign('title', '商品统计');
	}
}