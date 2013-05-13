<?php

class UserData extends BaseData
{

	public function addUserConnect($model)
	{
		$this->add($model);
	}
	
	public function addUser($model)
	{
		$model->password = md5 ( $model->password );
		$model->email = strtolower ( $model->email );
		$this->add ( $model );
	}

	public function getUserByEmail($name)
	{
		$this->where ( array (
						'email' => array (
										'=' => $name 
						) 
		) );
		$result = $this->findAll ();
		return $result;
	}
	
	public function getUserByNikename($nickname)
	{
		$this->where ( array (
				'nickname' => array (
						'=' => $nickname
				)
		) );
		$result = $this->findOne();
		return $result;
	}
	

	/**
	 * 后台修改前台用户权限
	 * 
	 * @param unknown $userId        	
	 * @param unknown $power        	
	 */
	public function updateRegUserPower($userId, $power)
	{
		$sql = 'update user set power = ' . $power . ' where id = ' . $userId;
		$this->exec ( $sql );
	}

	/**
	 * 通过用户名和密码获取用户信息
	 */
	public function getUserInfo($email, $password)
	{
		$email = strtolower ( $email );
		$query = array ();
		$query ['email'] = $email;
		$query ['password'] = md5 ( $password );
		$line = array (
						'city',
						'email',
						'head',
						'id',
						'inviteid',
						'ischecked',
						'nickname',
						'otheraccount',
						'othersite',
						'point',
						'regtype',
						'status' 
		);
		$this->setLine ( $line );
		$this->where ( $query );
		$userModel = $this->findOne ();
		return $userModel;
	}

	/**
	 * 设置登录用户信息到缓存
	 * 
	 * @param unknown $sessionId        	
	 * @param unknown $userId        	
	 */
	public function setViewUserToCache($sessionId, $userId)
	{
		$memcache = new MemcacheDbLib ();
		$key = self::getUserLonginKey ( $sessionId );
		$userModel = $this->getOneById ( $userId );
		$modelStr = $userModel ? json_encode ( $userModel ) : null;
		$memcache->set ( $key, $modelStr, 0, 24 * 3600);
	}
	
	/**
	 * 删除用户登录信息
	 * @param unknown $sessionId
	 */
	public function delViewUserToCache($sessionId)
	{
		$memcache = new MemcacheDbLib ();
		$key = self::getUserLonginKey ( $sessionId );
		$memcache->delete($key);
	}
	
	/**
	 * 更加sessionId获取当前用户信息
	 */
	public function getCacheUserDataModel($sessionId)
	{
		$key = self::getUserLonginKey ( $sessionId );
		$memcache = new MemcacheDbLib ();
		$string = $memcache->get($key);
		if (!$string)
		{
			return false;
		}
		$arr = json_decode($string, true);
		$userModel = new UserDataModel();
		foreach ($userModel as $key => $val)
		{
			if (isset($arr[$key]))
			{
				$userModel->$key = $arr[$key];
			}
		}
		return $userModel;
	}

	public static function getUserLonginKey($sessionId)
	{
		return $sessionId . 'login';
	}

	/**
	 * 通过第三方登录数据获取用户信息
	 */
	public function getUserInfoByOther($openId, $type)
	{
		$sql = 'select t1.* from user as t1 inner join userconnect t2 on t2.userid = t1.id where t2.openid = "'.$this->escape($openId).'" and t2.sitetype = ' . (int)$type;
		$result  = $this->queryOne($sql, 'UserDataModel');
		return $result;
	}

	/**
	 * 修改用户的用户名
	 *
	 * @param unknown $userId        	
	 * @param unknown $nickname        	
	 */
	public function updateNickNameAndHead($userId, $nickname, $head)
	{
		$sql = 'update user set nickname = "' . $nickname . '",head = "' . $head . '" where id = ' . $userId;
		$this->exec ( $sql );
	}

	public function getUserByIds($ids)
	{
		$query = array ();
		$query ['id'] = array (
						'in' => $ids 
		);
		$this->where ( $query );
		$result = $this->findAll ();
		return $result;
	}

	public function change($model)
	{
		$this->updateModel ( $model );
	}

	public function getUserId($email)
	{
		$this->where ( array (
						'email' => array (
										'=' => $email 
						) 
		) );
		$result = $this->findOne ();
		return $result;
	}

	public function preSet($model)
	{
		$model->password = md5 ( $model->password );
		$model->setWorkFields ( array (
						'email',
						'nickname',
						'password' 
		) );
		$this->updateModel ( $model );
	}

	public function resetPasswd($userid, $newPass)
	{
		$sql = 'update user set password = "' . md5 ( $newPass ) . '" where id = ' . ( int ) $userid;
		$this->exec ( $sql );
	}

	public function editHead($userModel)
	{
		$userModel->setWorkFields ( 'head' );
		$this->updateModel ( $userModel );
	}

}
