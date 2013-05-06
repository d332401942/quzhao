<?php 

class ListsHomeBrandView extends BaseView
{
	
	public function index()
	{
		$pageCore = new PageCoreLib ();
		$pageCore->pageSize = 10;
		$page = 1;
		if (! empty ( $_GET ['page'] ) && ( int ) $_GET ['page'])
		{
			$page = ( int ) $_GET ['page'];
		}
		$state = null;
		if (isset($_GET['state']) && (int)$_GET['state'])
		{
			$state = $_GET['state'];
		}
		$temp = null;
		if (isset($_GET['temp']) && (int)$_GET['temp'])
		{
			$temp = $_GET['temp'];
		}
		$id = null;
		if (!empty($_GET['id']))
		{
			$id = (int)$_GET['id'];
		}
		$time = null;
		$strTime = null;
		$endTiem = null;
		if(isset($_GET['timeCount']) && $_GET['timeCount'] !== '')
		{
			$strTime =  $_GET['timeCount'].' 00:00:00';
			$endTiem =  $_GET['timeCount'].' 23:59:59';
			$strTime = strtotime($strTime);
			$endTiem = strtotime($endTiem);
			$time = $_GET['timeCount'];
		}
		$yueStr = null;
		$yueEnd = null;
		$yue = null;
        if (isset($_GET['yue']) && $_GET['yue'] !== '')
        {
			$yue = $_GET['yue'];
			$yueStr = '2013-'.$_GET['yue'].'-01 00:00:00';
			$yueEnd = '2013-'.$_GET['yue'].'-30 23:59:59';
			$yueStr = strtotime($yueStr);
			$yueEnd = strtotime($yueEnd);
        }
		
		$pageCore->currentPage = $page;
		//得到所有商品
		$business = M('BrandBusiness');
		$result = $business->getAll3($pageCore,$state,$id,$temp);
		
		$userid = null;
		if(!empty($_GET['userid']))
		{
			$userid = $_GET['userid'];
		}
		//得到总数
		$count = $business->getAllTotal($userid,$strTime,$endTiem,$yueStr,$yueEnd);
		//得到已经通过审核总数
		$tgCount = $business->tgCount($userid,$strTime,$endTiem,$yueStr,$yueEnd);
		
		
		$this->assign('id',$id);
		$this->assign('count',$count);
		$this->assign('tgCount',$tgCount);
		$this->assign('userid',$userid);
		$this->assign('date',$time );
		$this->assign('yue',$yue );
		$this->assign('model' ,$result);
		$this->assign ( 'pageCore', $pageCore );
		$this->assign ( 'temp', $temp );
		$this->assign ( 'title', '品牌列表');
		
	}
	

}