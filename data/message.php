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
		$sql = 'select count(*) as num from message as t1 join user as t2 on t2.id = t1.userid where pid = ' . $pid;
		$row = $this->query ( $sql );
		$pageCore->count = $row [0] ['num'];
		$pageCore->pageCount = ceil ( $pageCore->count / $pageCore->pageSize );
		if ($isLastPage)
		{
			$pageCore->currentPage = $pageCore->pageCount;
		}
		$sql = 'SELECT m.id AS m_id, m.pid AS m_pid, m.userid AS m_userid, m.creattime AS m_creattime, m.message AS m_message, r.id AS r_id, r.userid AS r_userid, r.content AS r_content FROM message AS m LEFT JOIN reply AS r ON r.messageid = m.id ';
		$sql .= ' where m.pid = ' . $pid . ' order by m.id asc limit ' . ($pageCore->currentPage - 1) * $pageCore->pageSize . ',' . $pageCore->pageSize;
		
		//$sql = 'select t1.*,t2.nickname from message as t1 join user as t2 on t2.id = t1.userid where pid = ' . $pid . ' order by id asc limit ' . ($pageCore->currentPage - 1) * $pageCore->pageSize . ',' . $pageCore->pageSize;
		
		$statement = $this->run($sql);
		$messageModels = array();
		$userIds = array();
		while ($result = $statement->fetch(PDO::FETCH_ASSOC))
		{
			if (isset($userIds[$result['m_userid']]))
			{
				array_push($userIds, $result['m_userid']);
			}
			if (isset($userIds[$result['r_userid']]))
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
		//P($userIds);
		//P($messageModels);
		//exit;
		return $messageModels;
	}

}
