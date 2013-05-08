<?php

class AssociatedAjaxView extends BaseAjaxView
{
	public function del()
	{
		if(!empty($_POST['ids']) && trim($_POST['ids']))
		{
			$buesiness = M('AssociatedBusiness');
			$buesiness->del($_POST['ids']);
			$this->response(true);
		}
	}
	
	public function getAll()
	{
		if(!empty($_POST['pid']) && (int)$_POST['pid'])
		{
			$buesiness = M('AssociatedBusiness');
			$result = $buesiness->getCate($_POST['pid'],(int)$_POST['level']);
			$this->response($result);
		}
	}

}

