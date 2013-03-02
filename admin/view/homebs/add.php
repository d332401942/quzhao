<?php

class AddHomebsView extends BaseView
{

	public function index()
	{
		// 得到所有分类
		if ($_POST)
		{
			$this->add();
		}
        $id = null;
        if ($_GET['id'])
        {
            $id = (int)$_GET['id'];
        }
        $homeBsDataBusiness = new HomeBsDataBusiness();
        $model = $homeBsDataBusiness->getOneById($id);
        if (!$model)
        {
            $model = new HomeBsDataDataModel();
        }
        
		$homeBsClassBusiness = new HomeBsClassBusiness();
		$classModels = $homeBsClassBusiness->findAll();
		$this->assign('classModels', $classModels);
        $this->assign('dataModel', $model);
		$this->assign('title', '合作商家');
	}

	private function add()
	{
		$business = new HomeBsDataBusiness();
		$model = new HomeBsDataDataModel();
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
				unlink($fileName);
				$model->pic = $picName;
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
		$model->bid = (int)$model->bid;
        if (!empty($_POST['id']))
        {
            $business->updateByModel($model);
        }
        else
		{
            $business->add($model);
		}
        $this->success('操作成功', '');
	}
}