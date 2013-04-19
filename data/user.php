<?php

class UserData extends BaseData
{

    public function addUser ($model)
    {
        $model->password = md5($model->password);
        $model->email = strtolower($model->email);
        $this->add($model);
    }

    public function checkuser ($name)
    {
        $this->where(array(
                'email' => array(
                        '=' => $name
                )
        ));
        $result = $this->findAll();
        return $result;
    }

    /**
     * 通过用户名和密码获取用户信息
     */
    public function getUserInfo ($email, $password)
    {
        $email = strtolower($email);
        $query = array();
        $query['email'] = $email;
        $query['password'] = md5($password);
        $line = array(
                'city',
                'email',
                'id',
                'inviteid',
                'ischecked',
                'nickname',
                'otheraccount',
                'othersite',
                'point',
                'regtype',
                'status',
        );
        $this->setLine($line);
        $this->where($query);
        $userModel = $this->findOne();
        return $userModel;
    }

    public function change ($model)
    {
        $this->updateModel($model);
    }
    
}
