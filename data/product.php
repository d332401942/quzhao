<?php

class ProductData extends BaseData
{

	public function searchProductByIds($ids, $fields = array())
	{
		if ($fields)
		{
			$fields = '`' . implode ( '`,`', $fields ) . '`';
		}
		else
		{
			$fileds = '*';
		}
		$this->selectSearchMasterDb();
		$sql = 'select ' . $fileds . ' from `product` where productid in (' . implode ( ',', $ids ) . ')';
		$statement = $this->run ( $sql );
		$productModels = array ();
		while ( $productModel = $statement->fetchObject ( 'ProductDataModel' ) )
		{
			$productModels [$productModel->productid] = $productModel;
		}
		return $productModels;
	}

	/**
	 * 得到用户浏览单品的记录
	 *
	 * @param array $arrIds
	 *        	浏览的ID
	 */
	public function searchBrowseHistoryModels($arrIds)
	{
		if (! $arrIds)
		{
			return array ();
		}
		$this->selectSearchSlaveDb();
		$sql = 'select * from product where productid in (' . implode ( ',', $arrIds ) . ')';
		$models = $this->query ( $sql, 'ProductDataModel' );
		$idToModel = array ();
		foreach ( $models as $model )
		{
			$idToModel [$model->productid] = $model;
		}
		$result = array ();
		foreach ( $arrIds as $id )
		{
			if (isset ( $idToModel [$id] ))
			{
				$result [] = $idToModel [$id];
			}
		}
		return $result;
	}

	/**
	 * 修改产品喜欢次数
	 */
	public function loveNum($id)
	{
		$this->selectSearchMasterDb();
		$sql = 'update product set lovenumber = lovenumber+1 where productid = ' . $id;
		$this->exec ( $sql );
	}

}
