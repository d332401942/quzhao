<?php 

class HomeBsDataData extends BaseData
{
	/**
	 * 得到热门商家数据
	 */
	public function getHomeBsModels()
	{
		$sqlData = 'select * from home_bs_data order by sort desc';
		$sqlClass = 'select * from home_bs_class order by sort desc limit 6';
		$dataModels = $this->query($sqlData,'HomeBsDataDataModel');
		$classModels = $this->query($sqlClass,'HomeBsClassDataModel');
		
		foreach ($dataModels as $model)
		{
			$dataBidToModel[$model->bid][] = $model;
		}
		foreach ($classModels as $model)
		{
			if (isset($dataBidToModel[$model->id]))
			{
				$model->data = $dataBidToModel[$model->id];
			}
		}
		return $classModels;
	}
}