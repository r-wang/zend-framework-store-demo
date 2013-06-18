<?php
class Pagination {
	private $pagenow;
	private $pagesize;
	private $pagecount;
	private $url;
	
	public function __construct($pagenow, $pagesize, $pagecount, $url) {
		$this->pagenow = $pagenow;
		$this->pagesize = $pagesize;
		$this->pagecount = $pagecount;
		$this->url = $url;
	}
	
	public function paging() {
		
		$paging = "";
		
		if ($this->pagecount == 1) {
			return null;
		}
		
		if ($this->pagenow > 0) {
			$pageminus = $this->pagenow - 1;
			$paging = $paging . "<li class=\"previous hidden\"><a href=\"$this->url&page=$pageminus\">上一页</a></li>";
		
		}
		
		for($i = 0; $i < $this->pagecount; $i ++) {
			$temp = $i + 1;
			$temppage = $this->pagenow + 1;
			
			if ($i == $this->pagenow) {
				
				$paging = $paging . "<li class=\"page_selected\"><a href=\"$this->url?&page=$i\">$temp</a></li>";
			} else {
				$paging = $paging . "<li class=\"page\"><a href=\"$this->url&page=$i\">$temp</a></li>";
			}
		}
		
		if ($temppage < $this->pagecount) {
			$paging = $paging . "<li class=\"previous hidden\"><a href=\"$this->url&page=$temppage\">下一页</a></li>";
		
		}
		
		return $paging;
	}
}