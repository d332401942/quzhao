<?php
class ShareUserView extends BaseView
{
	public function index()
	{
		if($_POST){
			$this->collect();
		}
		            
	}
	
	public function collect()
	{
		/*用户评论：http://rate.taobao.com/feedRateList.htm?callback=jsonp_reviews_list&userNumId=898225&auctionNumId=20018284589&siteID=7&currentPageNum=1&rateType=&orderType=sort_weight&showContent=1&attribute=
		id\=\"J_ImgBooth\"
		大家印象：
		http://rate.taobao.com/detailCommon.htm?callback=jsonp_reviews_summary2&userNumId=898225&auctionNumId=20018284589&siteID=7*/
		
		
		$url = isset($_POST['url'])?trim($_POST['url']):'';
		if($url)
		{
			//header("Content-type: text/html;charset=gbk");
			$content = file_get_contents($url);	
			$content = iconv('gbk','utf-8//IGNORE',$content);
			$imgPreg = '/<img id="J_ImgBooth".*src="(.*)".*\/?>/isUm';
			$image = preg_match($imgPreg,$content,$imageCon);
			if($image)
			{	
				$this->assign('image',$imageCon[1]);
			}
			$titlePreg = '/<h3>(.*)<\/h3>/isUm';
			$title = preg_match($titlePreg,$content,$titleCon);
			if($title)
			{	
				$this->assign('title',$titleCon[1]);
			}
			$liPreg = '/<ul class="attributes-list">(.*)<\/ul>/isUm';
			$attribute = preg_match($liPreg,$content,$attributeCon);
			if($attribute)
			{	
				$attributeCon = preg_replace('/<li.*>/isUm','<li><span>',$attributeCon[1]);
				$attributeCon = str_replace(':','</span>',$attributeCon);
				$this->assign('attribute',$attributeCon);
			}
		}
	}
	
}
?>