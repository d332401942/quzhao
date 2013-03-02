<?php 

class DataaddhomebrandView extends BaseView
{
	
	public function index()
	{
		
		if($_POST)
		{
			$this->add();
		}
		$business = new HomeBrandBusiness();
		$model = null;
		if (!empty($_GET['id']))
		{
			$id = (int)$_GET['id'];
			$model = $business->getDataById($id);
		}
		$model = $model ? $model : new HomeBrandDataDataModel();
		$startTime = $model->time_start ? $model->time_start : time();
		$startTime = FormCommon::date('time_start',date('Y-m-d H:i:s',$startTime),true);
		
		$endTime = $model->time_end ? $model->time_end : time();
		$endTime = FormCommon::date('time_end',date('Y-m-d H:i:s',$endTime),true);
		
		
		$homeBrandModels = $business->findAll();
		$homeBrandModels = $homeBrandModels ? $homeBrandModels : array();
		$this->assign('title','品牌推荐');
		$this->assign('model',$model);
		$this->assign('startTime',$startTime);
		$this->assign('endTime',$endTime);
		$this->assign('homeBrandModels',$homeBrandModels);
	}
	
	private function add()
	{
		$business = new HomeBrandBusiness();
		$model = new HomeBrandDataDataModel();
		$file = new FileUploadUtilLib('pic');
		$uploadInfo = $file->upload();
		$picName = null;
		if (empty($_POST['bid']) || !(int)$_POST['bid'])
		{
			throw new ViewExceptionLib('请选择类别');
		}
		if (empty($_POST['tjhref']))
		{
			throw new ViewExceptionLib('请填写连接');
		}
		
		if ($uploadInfo)
		{
			$fileName = $uploadInfo[0];
			$model->tjpic = $fileName;
			if (0 && file_exists($fileName))
			{
				$picName = $file->thumb($fileName, 464, 176);
				$model->tjpic = $picName;
				unlink($fileName);
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
		if (!$model->tjpic && !empty($_POST['oldpic']))
		{
			$model->tjpic = $_POST['oldpic'];
		}
		foreach($model as $key => $value)
		{
			if (isset($_POST[$key]))
			{
				$model->$key = $_POST[$key];
			}
		}
		$model->sort = (int)$model->sort;
		$model->time_end = strtotime($model->time_end);
		$model->time_start = strtotime($model->time_start);
		
		if ($model->id)
		{
			$business->updateModel($model);
		}
		else
		{
			$business->add($model);
		}
		$this->success('操作成功', '');
	}
}