<?php 
class PageControlView extends BaseControlView
{
    
    public function index($parameters)
    {
        //设置最大显示页数
		
        $showPage = 7;
        $goPage = empty($parameters['goPage']) ? 'goPage' : $parameters['goPage'];
        $pageCore = $parameters['pageCore'];
        $count = $pageCore->count;
        $currentPage = $pageCore->currentPage;
        $pageSize = $pageCore->pageSize;
        $pageCount = $pageCore->pageCount;
        $startRow = ($currentPage - 1) * $pageSize + 1;
        $endRow = $startRow + $pageSize - 1;
        if ($pageCount <= 1)
        {
            $endRow = $count;
            $pageSize = $count;
        }
        
        $showPage = $showPage > $pageCount ? $pageCount : $showPage;
        
        $middle = (int)($showPage / 2);
        $start = 1;
        $end = $pageCount;
        $start = $currentPage - $middle;
        $end = $currentPage + $middle;
        if ($start < 1)
        {
            $start = 1;
            $end = $showPage;
        }
        if ($end > $pageCount) 
        {
            $start = $pageCount - $showPage + 1;
            $end = $pageCount + 1;
        }
        if ($end - $start + 1 > $showPage)
        {
            $end = $end - 1;
        }
        if(isset($parameters['width'])){
			$this->assign('dp',$parameters['width']);
		}
        $this->assign('start', $start);
        $this->assign('goPage', $goPage);
        $this->assign('end', $end);
        $this->assign('count', $count);
        $this->assign('pageSize', $pageSize);
        $this->assign('startRow', $startRow);
        $this->assign('endRow', $endRow);
        $this->assign('currentPage', $currentPage);
        $this->assign('pageCount', $pageCount);
    }
}