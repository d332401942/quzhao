<?php

class MessageData extends BaseData
{

	public function addMsg($model)
	{
		$this->setOrder ( array (
						'id' => 'desc' 
		) );
		$this->where ( array (
						'pid' => $model->pid 
		) );
		$this->setLine ( 'storey' );
		$result = $this->findOne ();
		if (empty ( $result->storey ))
		{
			$model->storey = 1;
		} else
		{
			$model->storey = $result->storey + 1;
		}
		$this->add ( $model );
	}

	public function getAll($pageCore, $pid, $isLastPage = false)
	{
		$sql = 'SELECT count(*) as num FROM message AS m LEFT JOIN reply AS r ON r.messageid = m.id  where pid = ' . $pid;
		$row = $this->query ( $sql );
		//P($row);exit;
		$pageCore->count = $row [0] ['num'];
		$pageCore->pageCount = ceil ( $pageCore->count / $pageCore->pageSize );
		if ($isLastPage)
		{
			$pageCore->currentPage = $pageCore->pageCount;
		}
		$sql = 'SELECT m.storey as m_storey ,m.id AS m_id, m.pid AS m_pid, m.userid AS m_userid, m.creattime AS m_creattime, m.message AS m_message, r.id AS r_id, r.userid AS r_userid, r.content AS r_content FROM message AS m LEFT JOIN reply AS r ON r.messageid = m.id ';
		$sql .= ' where m.pid = ' . $pid . ' order by m.id asc,r.id asc limit ' . ($pageCore->currentPage - 1) * $pageCore->pageSize . ',' . $pageCore->pageSize;
		
		//$sql = 'select t1.*,t2.nickname from message as t1 join user as t2 on t2.id = t1.userid where pid = ' . $pid . ' order by id asc limit ' . ($pageCore->currentPage - 1) * $pageCore->pageSize . ',' . $pageCore->pageSize;
		
		$statement = $this->run($sql);
		$messageModels = array();
		$userIds = array();
		while ($result = $statement->fetch(PDO::FETCH_ASSOC))
		{
			if (isset($result['m_userid']))
			{
				array_push($userIds, $result['m_userid']);
			}
			if (isset($result['r_userid']))
			{
				array_push($userIds, $result['r_userid']);
			}
			$messageId = $result['m_id'];
			if (empty($messageModels[$messageId]))
			{
				$messageModel = new MessageDataModel();
				foreach ($messageModel as $key => $val) 
				{
					if (isset($result['m_' . $key]))
					{
						$messageModel->$key = $result['m_' . $key];
					}
				}
				$messageModels[$messageId] = $messageModel;
			}
			if (isset($result['r_id']))
			{
				$replyModel = new ReplyDataModel();
				foreach ($replyModel as $key => $val) 
				{
					if (isset($result['r_' . $key]))
					{
						$replyModel->$key = $result['r_' . $key];
					}
				}
				$messageModels[$messageId]->replys[$replyModel->id] = $replyModel;
			}
		}
		$userIds = array_unique($userIds);
		$userModels = array();
		if ($userIds)
		{
			$userModels = $this->getUserMessage($userIds);
		}
		foreach($userModels as $val)
		{
			foreach($messageModels as $k=>$v)
			{
				if($v->userid == $val->id)
				{
					$messageModels[$k]->nickname = $val->nickname;
				}
				foreach($v->replys as $kk=>$vv)
				{
					if($vv->userid == $val->id)
					{
						$v->replys[$kk]->nickname = $val->nickname;
					}
				}
			}
		}
		//P($messageModels);
		return $messageModels;
	}
	
	public function getMessageAll($pageCore)
	{
		$sql = "select count(*) as count from message as t1 join user as t2 on t2.id = t1.userid";
		$count = $this->query($sql);
		$pageCore->count = $count[0]['count'];
		$pageCore->pageCount = ceil($pageCore->count / $pageCore->pageSize);
		$sql = 'select t1.*,t2.email from message as t1 join user as t2 on t2.id = t1.userid order by id desc limit '.($pageCore->currentPage-1)*$pageCore->pageSize.','.$pageCore->pageSize;
		$result = $this->query($sql,'MessageDataModel');
		return $result;
	}
	
	public function delMsg($id,$userid=false)
	{
		$ids = is_array($id) ? $id : array($id);
		if($userid)
		{
			//用户自己删除
			$sql = 'delete from message where id in ('.implode(',', $ids).') AND userid = '.$userid;
		}else{
			//后台管理删除
			$sql = 'delete from message where id in ('.implode(',', $ids).')';
		}
		$this->exec($sql);
		
		//删除该评论下所有回复
		$sql = 'select * from reply where messageid in ('.implode(',', $ids).')';
		$result = $this->query($sql);
		if(!empty($result))
		{
			$sql2 = 'delete from reply where messageid in ('.implode(',', $ids).')';
			$this->exec($sql2);
		}
	}
	
	private function getUserMessage($ids)
	{
		$user = new UserData();
		return $user->getUserByIds($ids);
	}
	
	

}
