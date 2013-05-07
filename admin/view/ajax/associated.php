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
}

