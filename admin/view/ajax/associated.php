<?php

class AssociatedAjaxView extends BaseAjaxView
{
	public function getAll()
	{
		if($_POST)
		{
			if(!empty($_POST['lev']) && (int)$_POST['lev'])
			{
				//得到所有分类
				$cateBusiness = M('CategoryBusiness');
				$cateModel = $cateBusiness->getAll($pageCore,(int)$_POST['lev']);
				$this->response($cateModel);
			}
		}
	}
}

