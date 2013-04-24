<?php
class ResetUserView extends BaseView
{
	public function index($parameter)
	{
		echo '重设密码';
		//if($_POST)
		//{	$pass = trim($_POST['password']);
			//if(empty($pass))
			//{
				//抛出异常
		//	}
			P($parameter);
			if(empty($parameter))
			{
				//抛出异常
			}
			$key = array_keys($parameter);
			$val = array_values($parameter);
			$memcache = M('MemcacheDbLib');
			$json = $memcache->get($key[0]);
			if(!$json){
				//抛出异常
				echo '链接已失效';
				exit;
			}
			$arr = json_decode($json, true);
			if(empty($arr)){
				//抛出异常
			}
			if($arr[0] != $val[0]){
				//抛出异常
			}
			if(time() > $arr[1]){
				//抛出异常
			}
			P($arr);
			$memcache->delete($key[0]);
			//$business = M('UserBusiness');
			//$newPass = $_POST['password'];
			//$business->resetPasswd($key[0],$newPass);
		//}
		exit;
	}
}
?>