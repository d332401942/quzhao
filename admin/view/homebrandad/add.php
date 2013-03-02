<?php

/**
 * 广告添加
 */
class AddHomebrandadView extends BaseView
{

	public function index()
	{
		if ($_POST)
		{
			$this->add();
		}
		$model = null;
		$business = new HomeBrandAdBusiness();
		if (!empty($_GET['id']))
		{
			$model = $business->getOneById($_GET['id']);
		}
		$model = $model ? $model : new HomeBrandAdDataModel();
		$this->assign('title', '广告管理');
		$this->assign('model', $model);
	}

	private function add()
	{
		if (empty($_POST['name']))
		{
			throw new ViewExceptionLib('请填写广告名称');
		}
		if (empty($_POST['href']))
		{
			throw new ViewExceptionLib('请填写广告连接');
		}
		if (! isset($_POST['stype']) || $_POST['stype'] === null)
		{
			throw new ViewExceptionLib('请选择广告投放位置');
		}
		
		$business = new HomeBrandAdBusiness();
		$model = new HomeBrandAdDataModel();
		$file = new FileUploadUtilLib('pic');
		$uploadInfo = $file->upload();
		if ($uploadInfo)
		{
			$fileName = $uploadInfo[0];
			$model->pic = $fileName;
			if (0 && file_exists($fileName))
			{
				$model->pic = $fileName;
			}
			if (!$model->pic)
			{
				throw new ViewExceptionLib('请上传广告图片');
			}
		}
		if (! $model->pic && ! empty($_POST['oldpic']))
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
		$model->isvalid = (int)$model->isvalid;
		$model->ishtml = (int)$model->ishtml;
		$model->stype = (int)$model->stype;
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