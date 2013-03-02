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
}