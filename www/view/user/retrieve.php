<?php
class RetrieveUserView extends BaseView
{
	public function index()
	{
		//if($_POST){
		//	if(!preg_match(CommUtility::EMAIL_PATTERN,$_POST['email']))
			//{
				//抛出异常
			//	$this->throwException('邮箱格式不正确',CodeException::USER_EAMIL_FORMAT);
			//}
			//查询用户信息
			$business = M('RetrieveBusiness');
			$userModel = $business->getUserId('67063492@qq.com');
			if(!$userModel)
			{
				//抛出异常
			}
			
			//实例化邮件类
			$email = new MailCoreLib();
			$model = new MailModelLib();
			$key = CommUtility::randStr();
			$arr = array($key,time()+86400);
			$memVal = json_encode($arr);
			$url = 'http://'.$this->ServerName.'/user/reset'.Config::URL_LIMIT_GET.$userModel->id.'/'.$key;
			
			//设置缓存
			$business->setMemcache($userModel->id,$memVal);
			
			//获取邮件内容
			$view = new ResetpasswordEmailView();
			$time = date('Y年m月d日 H:i:s',time());
			$date = date('Y年m月d日',time());	
			$view->assign('url', $url);
			$view->assign('email', $userModel->email);
			$view->assign('time', $time);
			$view->assign('date', $date);
			$content = $view->getHtml('./www/template/email/resetpassword.html');
		
			//发送邮件
			$model->To		= $userModel->email;
			$model->Subject	= '趣找网找回密码邮件';
			$model->Content	= $content;
			$email->sendMail($model);
			
		//}
		exit;
	}
}
?>