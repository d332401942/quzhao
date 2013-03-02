<?php

class AddHomeBrandView extends BaseView
{

	public function index()
	{
		if ($_POST)
		{
			$this->add();
		}
		$model = null;
		if (! empty($_GET['id']))
		{
			$id = $_GET['id'];
			$business = new HomeBrandBusiness();
			$model = $business->getHomeBrandModelBy($id);
		}
		$model = $model ? $model : new HomeBrandDataModel();
		$this->assign('title', '添加品牌');
		$this->assign('model', $model);
	}

	private function add()
	{
		$business = new HomeBrandBusiness();
		$model = new HomeBrandDataModel();
		$file = new FileUploadUtilLib('pic');
		$uploadInfo = $file->upload();
		$picName = null;
		if ($uploadInfo)
		{
			$fileName = $uploadInfo[0];
			$model->pic = $fileName;
			if (0 && file_exists($fileName))
			{
				$picName = $file->thumb($fileName, 110, 52);
				$model->pic = $picName;
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
		if (!$model->pic && !empty($_POST['oldpic']))
		{
			$model->pic = $_POST['oldpic'];
		}
		foreach($model as $key => $value)
		{
			if (isset($_POST[$key]))
			{
				$model->$key = $_POST[$key];
			}
		}
		$model->sort = (int)$model->sort;
		$model->ishot = (int)$model->ishot;
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