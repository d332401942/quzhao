<?php

class ConnectModel extends Feng
{

	public $appIdQQ;

	public $appKeyQQ;

	public $redirectUriQQ;

	public $stepQQ1;

	public $stepQQ2;

	public $stepQQ3;

	public $stepQQ4;

	public $appIdTaobao;

	public $appKeyTaobao;

	public $redirectUriTaobao;

	public $stepTaobao1;

	public $stepTaobao2;

	public $appIdWeibo;

	public $appKeyWeibo;

	public $redirectUriWeibo;

	public $stepWeibo1;

	public $stepWeibo2;

	public $stepWeibo3;

	private $serverName;

	public function __construct($serverName = 'www.quzhao.com', $fromUrl = null)
	{
		$this->serverName = $serverName;
		$this->appIdQQ = '100384287';
		$this->appKeyQQ = 'b17db4b2e78d8b99ff322098a942736d';
		$this->redirectUriQQ = 'http://' . $serverName . '/callbak/qq';
		$this->stepQQ1 = 'http://openapi.qzone.qq.com/oauth/show?';
		$this->stepQQ1 .= 'which=ConfirmPage&display=pc&response_type=code&scope=all';
		$this->stepQQ1 .= '&client_id=' . $this->appIdQQ;
		$this->stepQQ1 .= '&redirect_uri=' . urlencode ( $this->redirectUriQQ );
		$this->stepQQ2 = 'https://graph.qq.com/oauth2.0/token';
		$this->stepQQ3 = 'https://graph.qq.com/oauth2.0/me';
		$this->stepQQ4 = 'https://graph.qq.com/user/get_user_info';
		
		$this->appIdTaobao = '21473267';
		$this->appKeyTaobao = '2bdcad7b04761455ef8f8409d1d94ec9';
		$this->stepTaobao1 = 'https://oauth.taobao.com/authorize';
		$this->stepTaobao2 = 'https://oauth.taobao.com';
		$this->redirectUriTaobao = 'http://' . $serverName . '/callbak/taobao';
		
		$this->appIdWeibo = '898856262';
		$this->appKeyWeibo = '91efc04eafab78e7e723b2905d63cb3c';
		$this->redirectUriWeibo = 'http://' . $serverName . '/callbak/weibo';
		$this->stepWeibo1 = 'https://api.weibo.com/oauth2/authorize';
		$this->stepWeibo1 .= '?client_id=' . $this->appIdWeibo;
		$this->stepWeibo1 .= '&response_type=code&redirect_uri=' . urlencode ( $this->redirectUriWeibo );
		$this->stepWeibo2 .= 'https://api.weibo.com';
		
		if ($serverName != 'www.quzhao.com')
		{
			$this->appIdTaobao = '1021473267';
			$this->appKeyTaobao = 'sandboxb04761455ef8f8409d1d94ec9';
			$this->stepTaobao1 = 'https://oauth.tbsandbox.com/authorize';
			$this->stepTaobao2 = 'https://oauth.tbsandbox.com';
		}
		$this->stepTaobao1 .= '?client_id=' . $this->appIdTaobao;
		$this->stepTaobao1 .= '&response_type=code';
		$this->stepTaobao1 .= '&redirect_uri=' . urlencode ( $this->redirectUriTaobao );
	}

}
