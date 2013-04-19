<?php
class ShareUserView extends BaseView
{
	public function index()
	{
		if(!empty($_POST['url']) && $_POST['url'] != '超值单品链接'){
			$this->collectTaobao();
		}
		            
	}
	
	public function collectTaobao()
	{
		/*用户评论：http://rate.taobao.com/feedRateList.htm?callback=jsonp_reviews_list&userNumId=898225&auctionNumId=20018284589&siteID=7&currentPageNum=1&rateType=&orderType=sort_weight&showContent=1&attribute=
		
		大家印象：
		http://rate.taobao.com/detailCommon.htm?callback=jsonp_reviews_summary2&userNumId=898225&auctionNumId=20018284589&siteID=7*/
		
		//header("Content-type: text/html;charset=gbk");
		$content = file_get_contents($_POST['url']);	
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
		//商品属性信息
		/*$liPreg = '/<ul class="attributes-list">(.*)<\/ul>/isUm';
		$attribute = preg_match($liPreg,$content,$attributeCon);
		if($attribute)
		{	
			$attributeCon = preg_replace('/<li.*>/isUm','<li><span>',$attributeCon[1]);
			$attributeCon = str_replace(':','</span>',$attributeCon);
			$this->assign('attribute',$attributeCon);
		}*/
		
	}
	
	public function collectTmall()
	{
		$content = file_get_contents($_POST['url']);
		$content = iconv('gbk','utf-8//IGNORE',$content);
		$titlePreg = '/<h3 data-spm="1000983".*>.*<a.*>(.*)<\/a>.*<\/h3>/isUm';
		$title = preg_match($titlePreg,$content,$titleCon);
		if($title){
			$this->assign('title',$titleCon[1]);
		}
		$imgPreg = '/<a id="J_ImgBooth".* style="background-image: url\("(.*)"\)>/isUm';
		$image = preg_match($imgPreg,$content,$imageCon);
		if($image)
		{	
			$this->assign('image',$imageCon[1]);
		}
		/*
		
		<a id="J_ImgBooth" class="tb-booth tb-s460" data-haszoom="700" style="background-image: url("http://img01.taobaocdn.com/bao/uploaded/i1/18245020938226669/T19ltRXzRfXXXXXXXX_!!0-item_pic.jpg_460x460.jpg");" target="_blank" href="http://www.taobao.com/view_image.php?pic=Wx0GGlFDXA1VUwMDWx0SCwkNGRFcVxxQW1UcCxMFRBkDCFdVV1cRRhpVRF1OQAwMAgEEAQBRQFhdWkVdF2ACCxkdITwRPhAqYGFqa2xgazZTS1tBGhBdWWxCHApdDhsL&title=wPa94MWu17AyMDEztLrPxNDCv%2B66q7Dmz9TK3U9M0KG9xb7Ft9bQ3c%2FQv%2BNEWjgwMM7317DFrr%2Fj19M%3D&version=2&c=MjZmYTRjYzg3NTdjMDZiYWY3MzdkZTA5NWY3Nzc3NzI%3D&itemId=22034792394&shopId=62497263&sellerRate=149799&dbId=&fv=9">
		
		
		*/
	}
	
}
?>