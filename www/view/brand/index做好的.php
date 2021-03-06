<?php 

class IndexBrandView extends BaseView
{
	
	public function index($parems)
	{
		$this->setMeta('品牌特卖_趣找购物搜索');
		//得到所有品牌
		$pageCore = new PageCoreLib ();
		$pageCore->pageSize = 20;
		$page = 1;
		if (! empty ( $parems['page'] ) && ( int ) $parems['page'])
		{
			$page = ( int ) $parems['page'];
		}
		$cid = null;
		if (! empty ( $parems['cid'] ) && ( int ) $parems['cid'])
		{
			$cid = ( int ) $parems['cid'];
		}
		$letter = null;
		if (! empty ( $parems['letter'] ))
		{
			$letter = trim($parems['letter']);
		}
		$mid = null;
		if (! empty ( $parems['mid'] ))
		{
			$mid = trim($parems['mid']);
		}
		$pageCore->currentPage = $page;
		//得到所有数据
		$business = M('BrandBusiness');
		$result = $business->getAll2($pageCore,$cid,$letter,$mid);
		//得到所有分类
		$cateBusiness = M('Brand_cateBusiness');
		$cate = $cateBusiness->getAll();
		//得到所有商家
		$business = M('MerchantsBusiness');
		$merchants = $business->getAll();
		$this->assign('mid', $mid);
		$this->assign('cid', $cid);
		$this->assign('page', $page);
		$this->assign('letter', $letter);
		$this->assign('sjModel', $merchants);
		$this->assign('cateModel', $cate);
		$this->assign('brandModel' ,$result);
		$this->assign ( 'pageCore', $pageCore );
	}
}