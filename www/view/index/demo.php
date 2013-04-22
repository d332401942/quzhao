<?php

class DemoIndexView extends BaseView
{

    public function index()
    {
		$mail = new MailModelLib();
		$m = new MailCoreLib();
		$mail->To = '332401942@qq.com';
		$mail->From = 'denghongfeng@quzhao.com';
		$mail->Subject = '密码重置';
		$mail->Content = '修改密码';
		$m->sendMail($mail);exit;
	}


}
