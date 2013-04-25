<?php 

class IndexBrandadminView extends BaseView
{
	
	public function index($parameters)
	{
		
		if(empty($_COOKIE['brand_id']) && empty($_COOKIE['brandModel']))
		{
			$this->redirect(APP_URL . '/brandadmin/login');
		}
		
		$id = isset($parameters['id'])?(int)$parameters['id']:'';
		$rows = array();
		if($id)
		{
			$oneBusiness = M('BrandBusiness');
			$rows = $oneBusiness ->getOneId($id);
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
			$model->userid = $_COOKIE['brand_id'];
			$model->createtime = time();
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
			if(!empty($_POST['cateid']))
			{
				$columnBusiness = M('Brand_columnBusiness');
				$columnBrand_columnModel = M('Brand_columnDataModel');
				$columnBrand_columnModel->brandid = $model->id;
				foreach($_POST['cateid'] as $val)
				{
					$columnBrand_columnModel->cateid = $val;
					if(!empty($_POST['brandid']) && (int)$_POST['brandid'])
					{
						$columnBusiness->update($columnBrand_columnModel);	
					}else{
						$columnBusiness->add($columnBrand_columnModel);
					}
				}
			}
			$this->redirect(APP_URL . '/brandadmin/lists');
		}
		$cateBusiness = M('Brand_cateBusiness');
		$result = $cateBusiness->getAll();
		$this->assign('cateModel', $result);
		$this->assign('model', $rows);
	}
	

}