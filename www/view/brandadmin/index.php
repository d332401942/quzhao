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
			
			$model->userid = $_COOKIE['brand_id'];
			$model->createtime = time();
			if(!empty($_POST['brandid']) && (int)$_POST['brandid'])
			{
				$model->id = $_POST['brandid'];
				$model->setWorkFields(array('userid', 'url', 'createtime', 'rebate', 'merchantsId'));
				$business->update($model);
			}else{
				$business->add($model);
			}
			$this->redirect(APP_URL . '/brandadmin/lists');
		}
		//得到所有商家
		$business = M('MerchantsBusiness');
		$merchants = $business->getAll();
		$this->assign('sjModel', $merchants);
		$this->assign('model', $brandModel);
	}
}