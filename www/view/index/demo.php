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
		$result = array();
		
		
		foreach($r as $key=>$val)
		{
			if($val->level == 1)
			{
				$result[$val->categoryid]['categoryid'] = $val->categoryid;
				$result[$val->categoryid]['name'] = $val->name;
				$result[$val->categoryid]['level'] = $val->level;
				unset($r[$key]);
			}
		}
		foreach($r as $key=>$val)
		{
			if($val->level == 2)
			{
				$pid1 = $val->pid1;
				if (empty($result[$pid1]['children']))
				{
					$result[$pid1]['children'] = array();
				}
				$result[$pid1]['children'][$val->categoryid]['categoryid'] = $val->categoryid;
				$result[$pid1]['children'][$val->categoryid]['name'] = $val->name;
				$result[$pid1]['children'][$val->categoryid]['level'] = $val->level;
				unset($r[$key]);
			}
		}
		foreach($r as $key=>$val)
		{
			if($val->level == 3)
			{
				$pid1 = $val->pid1;
				$pid2 = $val->pid2;
				if (empty($result[$pid1]['children'][$pid2]['children']))
				{
					$result[$pid1]['children'][$pid2]['children'] = array();
				}
				$result[$pid1]['children'][$pid2]['children'][$val->categoryid]['categoryid'] = $val->categoryid;
				$result[$pid1]['children'][$pid2]['children'][$val->categoryid]['name'] = $val->name;
				$result[$pid1]['children'][$pid2]['children'][$val->categoryid]['level'] = $val->level;
			}
		}
		
		$xml = new XmlVendorLib();
		$str = $xml->getXML($result);
		file_put_contents('1.xml',$str);
	}

}
