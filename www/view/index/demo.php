<?php

class DemoIndexView extends BaseView
{

    public function Index()
    {
		$redis = new RedisCoreLib();
		$redis->set('name',1);
		echo $redis->get('name');
    }


}
