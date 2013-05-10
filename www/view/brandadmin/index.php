<?php 

class IndexBrandadminView extends BaseView
{
	
	public function index($parameters)
	{
		
		if(!isset($_COOKIE['brand_id']) || !isset($_COOKIE['brandModel']) || !isset($_COOKIE['brand_name']))
		{
			$this->redirect(APP_URL . '/brandadmin/login');
		}
		
		$id = isset($parameters['id'])?(int)$parameters['id']:'';
		$brandModel = array();
		if($id)
		{
			$oneBusiness = M('BrandBusiness');
			$brandModel = $oneBusiness->getOneId($id);
		}
		
		if($_POST)
		{	
			//添加品牌数据
			$model = M('BrandDataModel');
			foreach($model as $key=>$val)
			{
				if(isset($_POST[$key]))
				{
					$model->$key = trim($_POST[$key]);
				}
			}
			$business = M('BrandBusiness');
			if(isset($_POST['brand_name_id']))
			{
				$res = $business->check((int)$_POST['brand_name_id'],(int)$_POST['merchantsId']);
				if(!empty($res))
				{
					die('该品牌商家已存在');
				}
			}
			$model->str_time = strtotime($_POST['time_start']);
			$model->end_time = strtotime($_POST['time_end']);
			$model->userid = $_COOKIE['brand_id'];
			$model->createtime = time();
			$model->temp = 1;
			if(!empty($_POST['brandid']) && (int)$_POST['brandid'])
			{
				$model->id = $_POST['brandid'];
				if(!empty($_POST['brand_name_id']) && (int)$_POST['brand_name_id'])
				{
					$model->setWorkFields(array('url', 'createtime', 'rebate', 'merchantsId','istj','maxrebate','brand_name_id','str_time','end_time'));
				}
				else
				{
					$model->setWorkFields(array('url', 'createtime', 'rebate', 'merchantsId','istj','maxrebate','str_time','end_time'));
				}
				$business->update($model);
			}else{
				try
				{
					$business->add($model);
				}
				catch(BusinessExceptionLib $e)
				{
					$message = $e->getMessage();
					$this->responseError($message);
				}
			}
			$this->redirect(APP_URL . '/brandadmin/lists');
		}
		$timeStart = isset($brandModel->str_time)?$brandModel->str_time : time();
		$timeEnd   = isset($brandModel->end_time) ? $brandModel->end_time : time();
		$dateFrom = FormCommon::date('time_start',date('Y-m-d H:i:s',$timeStart),true);
		$dateTo = FormCommon::date('time_end',date('Y-m-d H:i:s',$timeEnd),true);
		//得到所有商家
		$business = M('MerchantsBusiness');
		$merchants = $business->getAll();
		$this->assign('sjModel', $merchants);
		$this->assign('model', $brandModel);
		$this->assign('dateTo', $dateTo);
		$this->assign('dateFrom', $dateFrom);
	}
}