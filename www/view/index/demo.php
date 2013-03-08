<?php

class DemoIndexView extends BaseView
{

    public function Index()
    {
		$content = file_get_contents('http://s.click.taobao.com/t?e=zGU34CA7K%2BPkqB07S4%2FK0CITy7klz1ozEJ0n51R6O%2BEozWCqYN74K8Kc%2FNzVJuWReY%2Bb1X%2Bn7g%2Fqid%2FT91lbhzGybm7o6J7BkbJJv0K2NyKR33wd&pid=mm_14507426_0_0&frm=etao&sku=null');

		$arr = array('data' => $content);
		header('Content-type: application/pdf');
		echo $content;exit;
		echo json_encode($arr);exit;
		$redis = new RedisCoreLib();
		$redis->set('name',1);
		echo $redis->get('name');
    }


}
