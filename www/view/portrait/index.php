<?php 

class IndexPortraitView extends BaseView
{
    
	public $tmpImage = null;
	
    public function index()
    {
    	$this->mustLogin();
        if ($_FILES)
        {
        	$this->upload();
        }
        if (!$this->tmpImage)
        {
        	$this->tmpImage = $this->CurrentUser->head;
        }
        $this->assign('tmpImage', $this->tmpImage);
    }
    
    private function upload()
    {
    	$file = new FileUploadUtilLib('file');
    	$uploadInfo = $file->upload();
    	if ($uploadInfo)
    	{
    		$fileName = $uploadInfo[0];
    		$this->tmpImage = $fileName;
    	}
    }
}