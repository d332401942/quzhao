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