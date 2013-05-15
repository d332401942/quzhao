<?php

class DemoIndexView extends BaseView
{
    public function index()
    {
		
		/*$business = M('CategoryBusiness');
		
		//5000一下三级分类
		//$data3 = $business->suoyou();
		
		//5000以上三级分类
		$data53 = $business->suoyou3();
		
		//5000以上二级分类
		$data52 = $business->suoyou2();
		
		//5000以上一级分类
		$data51 = $business->suoyou1();
		
		
		foreach($data51 as $key=>$val)
		{
			echo $val->categoryid.'###'.$val->name.'<br />';
			foreach($data52 as $k=>$v)
			{
				if($v->pid1 == $val->categoryid)
				{
					echo '--'.$v->categoryid.'###'.$v->name.'<br />';
				}
				foreach($data53 as $kk=>$vv)
				{
					if($vv->pid2 == $v->categoryid)
					{
						echo '---'.$vv->categoryid.'###'.$vv->name.'<br />';
					}
				}
			}
			
		}
		
		exit;*/
    }

}
