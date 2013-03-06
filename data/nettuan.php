<?php 

class NetTuanData extends BaseData
{
	
	public function getCity()
	{
		//TODO 缓冲操作
		$sql = 'select * from net_tuan_city order by sort desc';
		$cityModels = $this->query($sql,'NetTuanCityDataModel');
		return $cityModels;
	}
    
    public function changeIstj($id,$istj)
    {
        $sql = 'update net_tuan_data set istj = '.$istj .' where id = '.$id;
        $this->exec($sql);
    }

	public function changeStatus($id, $status)
	{
		$ids = null;
		if (is_array($id))
		{
			foreach ($id as $v)
			{
				if ((int)$v)
				{
					$ids .= ',' . (int)$v;
				}
			}
		}
		else
		{	
			$ids = (int)$id;
		}
		$ids = trim($ids, ',');
		$sql = 'update net_tuan_data set sort = ' .(int)$status . ' where id in ('. $ids .')';
		$this->exec($sql);
	}
}
