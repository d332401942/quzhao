<?php 

class IndexPortraitView extends BaseView
{
    
	public $tmpImage = null;
	
    public function index()
    {
        if ($_FILES)
        {
        	$this->upload();
        }
        P($_POST);
        if (!$this->tmpImage)
        {
        	$this->tmpImage = $this->CurrentUser->head;
        }
        $this->assign('tmpImage', $this->tmpImage);
    }
    
    public function upload()
    {
    	$file = new FileUploadUtilLib('file');
    	$uploadInfo = $file->upload();
    	if ($uploadInfo)
    	{
    		$fileName = $uploadInfo[0];
    		$this->tmpImage = $fileName;
    	}
    }
    
    private function upload1()
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