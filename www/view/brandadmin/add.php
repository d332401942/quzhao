<?php 

class AddBrandadminView extends BaseView
{
	private $model;
	
	public function index()
	{
		if(!isset($_COOKIE['brand_id']) || !isset($_COOKIE['brandModel']) || !isset($_COOKIE['brand_name']))
		{
			$this->redirect(APP_URL . '/brandadmin/login');
		}
		$model = null;
		$business = new HomeTjDataBusiness();
		if (!empty($_GET['id']) && (int)$_GET['id'])
		{
			$id = (int)$_GET['id'];
			$model = $business->getOneById($id);
			$model = array_pop($model);
			
		}
		if (!$model)
		{
			$model = new HomeTjDataDataModel();
			$model->fid = HomeTjDataDataModel::FID_HAND_INPUT;
		}
		$this->model = $model;
		
		if (!empty($_POST))
		{
			
			$this->add();
		}
		
		
		$timeStart = $model->time_start ? $model->time_start : time();
		$timeEnd = $model->time_end ? $model->time_end : time();
		
		$dateFrom = FormCommon::date('time_start',date('Y-m-d H:m:s',$timeStart),true);
		$dateTo = FormCommon::date('time_end',date('Y-m-d H:m:s',$timeEnd),true);
		
		//得到所有分类
		$homeTjClassBusiness = new HomeTjClassBusiness();
		$allClassModels = $homeTjClassBusiness->findAll();
		
		$this->assign('allClassModels',$allClassModels);
		$this->assign('dateTo', $dateTo);
		$this->assign('dateFrom', $dateFrom);
		$this->assign('dataModel', $model);
	}
	
	private function add()
	{
		$business = new HomeTjDataBusiness();
		$model = $this->model;
		
		$file = new FileUploadUtilLib('pic');
		$uploadInfo = $file->upload();
		$picName = null;
		if ($uploadInfo)
		{
			$fileName = $uploadInfo[0];
			$model->pic = $fileName;
			if (0 && file_exists($fileName))
			{
				$picName = $file->thumb($fileName,320,320);
				unlink($fileName);
				$model->pic = $picName;
				if (!empty($_POST['oldpic']) && file_exists($_POST['oldpic']))
				{
					unlink($_POST['oldpic']);
				}
				if (!empty($_POST['oldpic']) && file_exists($_POST['oldpic']))
				{
					unlink($_POST['oldpic']);
				}
			}
		}
		
		if (!$model->pic && !empty($_POST['oldpic']))
		{
			$model->pic = $_POST['oldpic'];
		}
		foreach ($model as $key => $value)
		{
			if (isset($_POST[$key]))
			{
				$model->$key = $_POST[$key];
			}
		}
		if ($model->time_start)
		{
			$model->time_start = strtotime($model->time_start);
		}
		if ($model->time_end)
		{
			$model->time_end = strtotime($model->time_end);
		}
		if (!$model->ctime)
		{
			$model->ctime = time();
		}
		$model->ltime = time();
		$model->userid = $_COOKIE['brand_id'];
		$model->username = $_COOKIE['brand_name'];
		$model->tempType = 1; 
		if (!$model->id)
		{
			$model->state = HomeTjDataDataModel::STATE_DOWN;
		}
		$model->isvalid = HomeTjDataDataModel::ISVALID_YES;
        $model->ishot = (int)$model->ishot;
		
		if (empty($model->sort))
		{
			$model->sort = 0;
		}
		if($_FILES['pic']['name'] != '')
		{
			$this->setPic($model);
		}
		try
		{
			if ($model->id)
			{
				$business->updateModel($model);
			}
			else
			{
				$business->add($model);
			}
		}
		catch(BusinessExceptionLib $e)
		{	
			$message = $e->getMessage();
			$this->responseError($message);
		}			
	
		$this->redirect(APP_URL . '/brandadmin/dplists');
	}
	
	private function setPic($model)
	{
		$picUrl = $model->pic;
		if (preg_match('/^http:\/\//i', $picUrl))
		{
			$extensionName = pathinfo($picUrl,PATHINFO_EXTENSION);
			$path = 'public/uploads';
			if (!file_exists($path))
			{
				mkdir($path);
			}
			$pic = $path .'/'. microtime(true) .rand(10000, 99999).'.'.$extensionName;
			$content = file_get_contents($picUrl);
			file_put_contents($pic, $content);
			$file = new ImageUtilLib();
			$model->pic = $pic;
			if (0 && file_exists($pic))
			{
				$picName = $file->thumb($pic,320,320);
				unlink($pic);
				$model->pic = $picName;
			}
		}
	}
	

}