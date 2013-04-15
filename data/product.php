<?php

class ProductData extends BaseData
{
	
	public function searchProductByIds($ids, $keyword, $fields = array())
	{
		if ($fields)
		{
			$fields = '`' . implode('`,`', $fields) . '`';
		}
		else
		{
			$fileds = '*';
		}
		$this->selectDb(Config::DB_MYSQL_SEARCH_HOST, Config::DB_MYSQL_USERNAME, Config::DB_MYSQL_PASSWORD, Config::DB_MYSQL_SEARCH_DBNAME, Config::DB_MYSQL_SEARCH_PORT);
		$sql = 'select ' . $fileds . ' from `product` where productid in (' . implode(',', $ids) . ')';
		$statement = $this->run($sql);
		$productModels = array();
		foreach ($ids as $id)
		{
			$productModels[$id] = null;
		}
		while ($productModel = $statement->fetchObject('ProductDataModel'))
		{
			$productModels[$productModel->productid] = $productModel;
		}
		return $productModels;
	}

}
