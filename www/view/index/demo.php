<?php

class DemoIndexView extends BaseView
{
    public function index()
    {
		$business = M('CategoryBusiness');
		$r = $business->suoyou();
		
		//一级分类90个
		$level1 = array();
		
		//二级分类1377个
		$level2 = array();
		
		//三级分类5490个
		$level3 = array();
		
		foreach($r as $key=>$val)
		{
			if($val->level == 1)
			{
				$level1[] = $val;
			}
			if($val->level == 2)
			{
				$level2[] = $val;
			}
			if($val->level == 3)
			{
				$level3[] = $val;
			}
		}
		
		//二级分类 嵌套完成
		foreach($level1 as $key=>$val)
		{
			foreach($level2 as $k=>$v)
			{
				if($val->categoryid == $v->pid1)
				{
					$level1[$key]->children[] = $v;
				}
			
			}
		}
		
		foreach($level3 as $kk=>$vv)
		{
			foreach($level1 as $key=>$val)
			{
				if(!empty($val->children))
				{
					foreach($val->children as $k=>$v)
					{
						
						if($vv->pid2 == $v->categoryid)
						{
							$level1[$key]->children[$k]->children[] = $vv;
						}
						
					}
				}
				
			}
		}
		$xml = new XmlVendorLib();
		$str = $xml->getXML($level1);
		file_put_contents('1.xml',$str);
		//P($level1);
		//$res = fopen('arraaa.txt',"a");
		//$a = fwrite($res,$level1);
		//if(!$a)
		//{
		//	echo '写入失败';
		//}
		//$a = json_encode($level1);
		//echo $a;
	}

}
