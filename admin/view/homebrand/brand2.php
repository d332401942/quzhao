<?php 

class Brand2HomeBrandView extends BaseView
{
	
	public function index($parameters)
	{
		$id = isset($parameters['id'])?(int)$parameters['id']:'';
		$model = null;
		if($id)
		{
			$Business = M('BrandnameBusiness');
			$model = $Business->getId($id);
		}
		if($_POST)
		{	
			//添加品牌名称
			$brandNameBusiness = M('BrandnameBusiness');
			$res = $brandNameBusiness->checkname($_POST['name']);
			if(empty($res))
			{
				$brandNameModel = M('BrandnameDataModel');
				$brandNameModel->name = trim($_POST['name']);
				$brandNameModel->cateid = intval($_POST['cateid']);
				$brandNameModel->letter	= trim($_POST['letter']);
				if(!empty($_POST['id']))
				{
					$brandNameModel->id = $_POST['id'];
				}
				//上传图片
				$file = new FileUploadUtilLib('image');
				$uploadInfo = $file->upload();
				$picName = null;
				if ($uploadInfo)
				{
					$fileName = $uploadInfo[0];
					$brandNameModel->image = $fileName;
					if (0 && file_exists($fileName))
					{
						$picName = $file->thumb($fileName,320,320);
						unlink($fileName);
						$brandNameModel->image = $picName;
					}
				}
				if(!empty($_POST['oldimage']))
				{
					$brandNameModel->image = $_POST['oldimage'];
				}
				if($brandNameModel->id)
				{
					$brandNameBusiness->update($brandNameModel);
					$this->redirect(APP_URL . '/homebrand/editbrand');
				}else{
					$brandNameBusiness->add($brandNameModel);
				}
				
			}
			$this->redirect(APP_URL . '/homebrand/brand');
		}
		//得到所有分类
		$cateBusiness = M('Brand_cateBusiness');
		$result = $cateBusiness->getAll();
		$this->assign('cateModel', $result);
		$this->assign('model', $model);
		
	}
	

}