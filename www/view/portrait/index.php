<?php 

class IndexPortraitView extends BaseView
{
    
    public function index()
    {
        if ($_FILES)
        {
        	$this->upload();
        }
    }
    
    private function upload()
    {
    	$file = new FileUploadUtilLib('head');
    	$uploadInfo = $file->upload();
    	$picName = null;
    	if ($uploadInfo)
    	{
    		$fileName = $uploadInfo[0];
    		$userModel = $this->CurrentUser;
    		$userModel->head = $fileName;
    	}
    	//修改用户头像
    	$business = new UserBusiness();
    	$business->editHead($userModel);
    	//把用户信息记入cookie
		setcookie(BaseView::USER_INFO_COOKIE_KEY, json_encode($userModel), 0, '/');
    }
}