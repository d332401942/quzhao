<?php 

class NetDataData extends BaseData
{
	
	public function findAll()
	{
		$result = parent::findAll();
		self::getLastModel($result);
		return $result;
	}
	
	public function getOneById($id)
	{
		$result = parent::getOneById($id);
		self::getLastModel($result);
		return $result;
	}
	
	
	public function setState($id,$state)
	{
		$ids = is_array($id) ? $id : array($id);
		$sql = 'update net_data set state = '.$state . ' where id in ('.implode(',', $ids).')';
		$this->exec($sql);
	}
	
	private static function getLastModel($model)
	{
		if (!$model)
		{
			return false;
		}
		$models = is_array($model) ? $model : array($model);
		$arr = self::getTypeToClassId();
		foreach ($models as $model)
		{
			$classId = $model->classid;
			if (isset($arr[$classId]))
			{
				$model->tjClassid = $arr[$classId];
				self::reSetHref($model);
			}
		}
	}
	
	/**
	 * 重新设置连接 去除计费代码
	 * @param unknown_type $model
	 */
	private static function reSetHref($model)
	{
		$href = $model->href;
		if (strlen($href) < 4)
		{
			return ;
		}
		$num = stripos($href,'http',4);
		if (!$num)
		{
			return ;
		}
		$href = substr($href, $num);
		$model->href = urldecode($href);
	}
	
	/**
	 * 得到类型与数据库中对于的ID
	 * @return multitype:number
	 */
	private static function getTypeToClassId()
	{
		return array(
				NetDataDataModel::CLASS_ID_TYPE_DP => 2,
				NetDataDataModel::CLASS_ID_TYPE_NINE => 1,
		);
	}
}