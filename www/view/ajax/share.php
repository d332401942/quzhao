<?php
class ShareAjaxView extends AjaxCoreLib
{
	const IMAGE_CODE = 1;
	const TITLE_CODE = 2;
	public function index()
	{
		if(!empty($_POST['url']) && $_POST['url'] != '超值单品链接'){
			$tmall = stristr($_POST['url'],'tmall.com');
			if($tmall)
			{	
				$this->collectTmall();	
			}
			$taobao = stristr($_POST['url'],'taobao.com');
			if($taobao)
			{	
				$this->collectTaobao();	
			}
		}
		            
	}
	
	public function collectTaobao()
	{
		$content = file_get_contents($_POST['url']);	
		$content = iconv('gbk','utf-8//IGNORE',$content);
		$imgPreg = '/<img id="J_ImgBooth".*src="(.*)".*\/?>/isUm';
		$image = preg_match($imgPreg,$content,$imageCon);
		if(!$image)
		{	
			//抛出异常
		}
		$titlePreg = '/<h3>(.*)<\/h3>/isUm';
		$title = preg_match($titlePreg,$content,$titleCon);
		if(!$title)
		{	
			//抛出异常
		}
		$titleCon = str_replace('<span class="tb-double-tag"></span>','',$titleCon[1]);
		$success = array('image'=>array('message'=>$imageCon[1]),'title'=>array('message'=>$titleCon),'origin'=>'淘宝');
		$this->response($success);
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
		if(!$title){
			//抛出异常
		}
		$imgPreg = '/<a.*style="background-image\:url\((.*)\)" id="J_ImgBooth".*>/isUm';
		$image = preg_match($imgPreg,$content,$imageCon);
		if(!$image)
		{	
			//抛出异常
		}
		$success = array('image'=>array('message'=>$imageCon[1]),'title'=>array('message'=>$titleCon[1]),'origin'=>'天猫');
		$this->response($success);
	}
	
}
?>