<?php 

class AddContentView extends BaseView
{
	
	private $model;
	
	public function index()
	{
		$model = null;
		$business = new HomeTjDataBusiness();
		if (!empty($_GET['id']) && (int)$_GET['id'])
		{
			$id = (int)$_GET['id'];
			$model = $business->getOneById($id);
			
		}
		else if (!empty($_GET['netdataid']) && (int)$_GET['netdataid'])
		{
			$model = $business->getNetDataToModel((int)$_GET['netdataid']);
		}
		else if(!empty($_GET['shareid']) && (int)$_GET['shareid'])
		{
			$business = M('ShareBusiness');
			$shareModel = $business->getShareModel($_GET['shareid']);
		}
		if (!$model)
		{
			$model = new HomeTjDataDataModel();
			$model->fid = HomeTjDataDataModel::FID_HAND_INPUT;
		}
		$this->model = $model;
		if(!empty($shareModel))
		{
			$model = new HomeTjDataDataModel();
			$model->name 	= $shareModel->title;
			$model->info 	= $shareModel->content;
			$model->pic  	= $shareModel->image;
			$model->href 	= $shareModel->url;
			$model->price 	= $shareModel->price;
			$model->isvalid = HomeTjDataDataModel::ISVALID_YES;
			$model->name 	= $shareModel->title;
			$model->name 	= $shareModel->title;
			$model->name 	= $shareModel->title;
			$model->name 	= $shareModel->title;
			$model->shareid = $shareModel->id;
			$this->model = $model;
			if (!empty($_POST))
			{
				$this->addShare();
			}
		}
		if (!empty($_POST))
		{
			$this->add();
		}
		
		
		$this->assign('title','内容管理');
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
		if ($model->id)
		{
			$business->updateModel($model);
		}
		else
		{	
			$md5Url = md5($_POST['oldpic']);
			$path = $this->getImagePath($md5Url);
			CommUtilLib::rMkdir('./public/uploads/images/'.$path);
			$pic = file_get_contents($_POST['oldpic']);
			file_put_contents('./public/uploads/images/'.$path.'/'.$md5Url.'.jpg',$pic);
			$model->pic = './public/uploads/images/'.$path.'/'.$md5Url.'.jpg';
			$business->add($model);
		}
		$netdataid = null;
		if (!empty($_GET['netdataid']))
		{
			$netdataid = $_GET['netdataid'];
			$netDataBusiness = new NetDataBusiness();
			$netDataBusiness->setState($netdataid, NetDataDataModel::STATUS_NO);
		}
		$url = APP_URL.'/content/add?id='.$model->id;
		if ($netdataid)
		{
			$url = APP_URL. '/netdata';
		}
		if (empty($model->sort))
		{
			$model->sort = 0;
		}
		$this->success('操作成功',$url);
	}
	
	public function addShare()
	{
		$model = $this->model;
		$business = new HomeTjDataBusiness();
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
		if($_FILES['pic']['name'] != '')
		{
			$this->setPic($model);
		}
		if(empty($_POST['eprice']))
		{
			$model->eprice = 0;
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
		if (!$model->id)
		{
			$model->state = HomeTjDataDataModel::STATE_DOWN;
		}
		$model->isvalid = HomeTjDataDataModel::ISVALID_YES;
		if ($model->id)
		{
			$business->updateModel($model);
		}
		else
		{	
			$business->add($model);
		}
		if(!empty($_GET['shareid']) && (int)$_GET['shareid'])
		{
			$business = M('ShareBusiness');
			$business->setState($_GET['shareid'],ShareDataModel::SHARE_STATUS_OK);
		}
		$this->success('操作成功',APP_URL.'content');
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
	protected function getImagePath($md5Url)
	{
		$path = '';
		for ($i=0; $i<4; $i++)
		{
			$path .= '/' . substr($md5Url, $i * 2, 2);
		}
		$path = ltrim($path, '/');
		return $path;
	}

	
}
