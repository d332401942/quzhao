<?php 

class MessagelettersBusiness
{
	
	/**
	 * 给用户发送一个评论通知
	 * @param 用户ID $userId
	 * @param 商品ID $pid
	 * @param 商品类型 $type
	 */
	public function add($userId, $pid, $type = MessagelettersDataModel::TYPE_DP)
	{
		
		$model = new MessagelettersDataModel();
		$model->isread = MessagelettersDataModel::IS_NO;
		$model->readtime = 0;
		$model->pid = $pid;
		$model->createtime = time();
		$model->type = $type;
		$model->userid = $userId;
		$data = M('MessagelettersData');
		$data->add($model);
	}
}