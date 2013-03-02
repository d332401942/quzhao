<?php


/**
 * 合作商家分类
 * @author Administrator
 *
 */
class HomeBsClassData extends BaseData
{
	
    public function updateClassSort($id,$value)
    {
        $sql = 'update home_bs_class set sort = '. (int)$value . ' where id = '.$id;
        $this->exec($sql);
    }
    
    public function updateClassName($id,$value)
    {
        $sql = 'update home_bs_class set name = "'.$value.'" where id = '.$id;
        $this->exec($sql);
    }
}