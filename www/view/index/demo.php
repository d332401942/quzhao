<?php

class DemoIndexView extends BaseView
{

    public function index()
    {
		$mail = new MailModelLib();
		$m = new MailCoreLib();
		$mail->To = '332401942@qq.com';
		$mail->From = 'denghongfeng@quzhao.com';
		$m->sendMail($mail);exit;
	}


}
