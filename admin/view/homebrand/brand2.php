<?php 

class Brand2HomeBrandView extends BaseView
{
	
	public function index($parameters)
	{
		
		
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
				$brandNameBusiness->add($brandNameModel);
			}
			$this->redirect(APP_URL . '/homebrand/brand');
		}
		//得到所有分类
		$cateBusiness = M('Brand_cateBusiness');
		$result = $cateBusiness->getAll();
		$this->assign('cateModel', $result);
		
	}
	

}