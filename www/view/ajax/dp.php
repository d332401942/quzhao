<?php 

class DpAjaxView extends BaseAjaxView
{
	
	/**
	 * 前台超级会员调整排序
	 */
	public function upSort()
	{
		$id = !empty($_GET['id']) ? (int)$_GET['id'] : null;
		if (empty($this->CurrentUser->id))
		{
			$this->responseError('没有权限');
		}
		$userId = $this->CurrentUser->id;
		if (!$id)
		{
			$this->responseError('商品ID为空');
		}
		$business = new HomeTjDataBusiness();
		$business->upSort($id, $userId);
		$this->response(true);
	}
	
	/**
	 * 前台超级会员调整排序
	 */
	public function defSort()
	{
		$id = !empty($_GET['id']) ? (int)$_GET['id'] : null;
		if (empty($this->CurrentUser->id))
		{
			$this->responseError('没有权限');
		}
		$userId = $this->CurrentUser->id;
		if (!$id)
		{
			$this->responseError('商品ID为空');
		}
		$business = new HomeTjDataBusiness();
		$business->defSort($id, $userId);
		$this->response(true);
	}
}