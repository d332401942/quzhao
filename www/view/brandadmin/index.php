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
			$brandModel = $oneBusiness ->getOneId($id);
		}
		
		if($_POST)
		{
			$model = M('BrandDataModel');
			foreach($model as $key=>$val)
			{
				if(isset($_POST[$key]))
				{
					$model->$key = trim($_POST[$key]);
				}
			}
			if(empty($_POST['name']))
			{
				$model->name = $_POST['name2'];
			}
			$model->userid = $_COOKIE['brand_id'];
			$model->createtime = time();
			//上传图片
			$file = new FileUploadUtilLib('image');
			$uploadInfo = $file->upload();
			$picName = null;
			if ($uploadInfo)
			{
				$fileName = $uploadInfo[0];
				$model->image = $fileName;
				if (0 && file_exists($fileName))
				{
					$picName = $file->thumb($fileName,320,320);
					unlink($fileName);
					$model->image = $picName;
				}
			}
			$business = M('BrandBusiness');
			if(!empty($_POST['brandid']) && (int)$_POST['brandid'])
			{
				$model->id = $_POST['brandid'];
				$business->update($model);
			}else{
				$business->add($model);
			}
			
			$this->redirect(APP_URL . '/brandadmin/lists');
		}
		//得到所有分类
		$cateBusiness = M('Brand_cateBusiness');
		$result = $cateBusiness->getAll();
		//得到所有商家
		$business = M('MerchantsBusiness');
		$merchants = $business->getAll();
		
		
		$this->assign('sjModel', $merchants);
		$this->assign('cateModel', $result);
		$this->assign('model', $brandModel);
		
	}
	

}