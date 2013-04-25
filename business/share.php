<?php

class ShareBusiness extends BaseBusiness
{
    public function addShare($model)
    {
		$data = new ShareData();
		$model->image = $this->downImg($model->image);
		$data->add($model);
    }
	
	public function findAll($pageCore,$cateId)
	{
		$data = M('ShareData');	
		$result = $data->findShare($pageCore,$cateId);
		return $result;
	}
	
	public function setState($id,$status)
	{
		$data = new ShareData();
		$data->setState($id,$status);
	}
	
	public function getShareModel($id)
	{
		$data = M('ShareData');	
		$result = $data->getOneById($id);
		return $result;
	}
	
	public function getShare($pageCore,$userid)
	{
		$data = new ShareData();
		$result = $data->getShare($pageCore,$userid);
		return $result;
	}
	private function downImg($url)
	{
		$md5Url = md5($url);
		$path = $this->getImagePath($md5Url);
		CommUtilLib::rMkdir('./public/uploads/images/'.$path);
		$pic = file_get_contents($url);
		file_put_contents('./public/uploads/images/'.$path.'/'.$md5Url.'.jpg',$pic);
		$url = '/public/uploads/images/'.$path.'/'.$md5Url.'.jpg';
		return $url;
	}
	
	protected function getImagePath($md5Url)
	{
		$path = '';
		for ($i=0; $i<4; $i++)
		{
			$path .= '/' . substr($md5Url, $i * 2, 2);
		}
		$path = ltrim($path, '/');
		return $path;
	}
}
