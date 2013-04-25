<?php

class UserData extends BaseData
{

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
	 * 通过第三方登录数据获取用户信息
	 */
	public function getUserInfoByOther($openId, $type)
	{
		$query = array ();
		$query ['regtype'] = $type;
		$query ['openid'] = $openId;
		$this->where ( $query );
		return $this->findOne ();
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
		$userModel->setWorkFields('head');
		$this->updateModel($userModel);
	}

}
