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
		
		$starTime = null;
		if(!empty($_GET['time_start']))
		{
			$starTime = $_GET['time_start'];
		}
		
		$endTime = null;
		if(!empty($_GET['time_end']))
		{
			$endTime = $_GET['time_end'];
		}
		
		/*
		 *得到数据数目
		 */
		$business = new HomeTjDataBusiness();
		$totalNumTrue = $business->getDayNumber($starTime, $endTime, 1,$isPart);
		$totalNumFalse = $business->getDayNumber($starTime, $endTime, 0,$isPart);
		
		
		/*
		 *合并查询结果
		 */
		$result = array();
		$userIds = array();
		foreach ($totalNumTrue as $id => $val)
		{
			if (!in_array($id, $userIds))
			{
				array_push($userIds, $id);
			}
		}
		foreach ($totalNumFalse as $id => $val)
		{
			if (!in_array($id, $userIds))
			{
				array_push($userIds, $id);
			}
		}
		//小计
		$totalArr = array();
		$totalArr[] = '小计';
		$totalArr[] = 0;
		$totalArr[] = 0;
		$totalArr[] = 0;
		foreach ($userIds as $id)
		{
			$userName = empty($totalNumFalse[$id]['username']) ? $totalNumTrue[$id]['username'] : $totalNumFalse[$id]['username'];
			$trueNum = !empty($totalNumTrue[$id]['num']) ? (int)$totalNumTrue[$id]['num'] : 0;
			$totalArr[1] += $trueNum;
			$falseNum = !empty($totalNumFalse[$id]['num']) ? (int)$totalNumFalse[$id]['num'] : 0;
			$totalArr[2] += $falseNum;
			$totalNum = $trueNum + $falseNum;
			$totalArr[3] += $totalNum;
			array_push($result, array($userName,$trueNum,$falseNum,$totalNum));
		}
		array_unshift($result, $totalArr);
		/**
		 * 日期插件
		 */
		$this->assign('result', $result);
		$dateFrom = FormCommon::date('time_start',date('Y-m-d H:i:s'),true);
		$dateTo = FormCommon::date('time_end',date('Y-m-d H:i:s'),true);
		$this->assign('dateTo', $dateTo);
		$this->assign('dateFrom', $dateFrom);
		$this->assign('title', '商品统计');
	}
}