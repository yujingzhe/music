<?php
namespace ajax;
class Page
{
	//每页显示的数量
	protected $number;
	//总数
	protected $totalCount;
	//一共多少页
	protected $totalPage;
	//当前页
	protected $page;
	//url
	protected $url;

	public function __construct($number=5, $totalCount=60)
	{
		$this->number = $number;
		$this->totalCount = $totalCount;
		$this->totalPage = $this->getTotalPage();
		$this->page = $this->getPage();
		$this->url = $this->getUrl();
	}

	protected function getTotalPage()
	{
		return ceil($this->totalCount / $this->number);
	}

	protected function getPage()
	{
		if (empty($_GET['page'])) {
			$page = 1;
		} else {
			$page = $_GET['page'];
		}
		return $page;
	}

	protected function getUrl()
	{
		//得到协议的名字
		$scheme = $_SERVER['REQUEST_SCHEME'];
		//得到主机名
		$host = $_SERVER['SERVER_NAME'];
		//得到端口
		$port = $_SERVER['SERVER_PORT'];
		//得到剩下的
		$pathData = $_SERVER['REQUEST_URI'];

		//http://localhost/index.php?user=123&page=1
		//http://localhost/index.php?page=1
		//http://localhost/index.php?user=123
		//http://localhost/index.php
		$data = parse_url($pathData);
		/**
		 * $data = [
		 * 		'path' => 'index.php',
		 * 		'query' => 'user=123&page=1';
		 * ];
		 */
		$path = $data['path'];
		//判断是否有query字符串
		if (!empty($data['query'])) {
			parse_str($data['query'], $arr);
			/**
			 * $arr = [
			 * 		'user'=>123,
			 * 		'page'=>1
			 * ];
			 */
			unset($arr['page']);
			$query = http_build_query($arr);
			// $query = 'user=123';
			$path = $path .'?'. $query;
		}
		
		$path = trim($path, '?');
		//拼接完整的url地址
		$url =  $path;
		return $url;
	}
	protected function setUrl($str)
	{
		if (strstr($this->url, '?')) {
			return $this->url . '&' . $str;
		} else {
			return $this->url . '?' . $str;
		}
	}
	protected function first()
	{
		return $this->setUrl('page=1');
	}
	protected function prev()
	{
		if ($this->page - 1 < 1) {
			$page = 1;
		} else {
			$page = $this->page - 1;
		}
		return $this->setUrl('page='.$page);
	}
	protected function next()
	{
		if ($this->page + 1 > $this->totalPage) {
			$page = $this->totalPage;
		} else {
			$page = $this->page + 1;
		}
		return $this->setUrl('page='.$page);
	}
	protected function end()
	{
		return $this->setUrl('page='.$this->totalPage);
	}

	public function allPage()
	{
		return [
			'first' => $this->first(),
			'prev' => $this->prev(),
			'next' => $this->next(),
			'end' => $this->end()
		];
	}
	public function limit()
	{
		$offset = ($this->page-1) * $this->number;
		$offset = $offset . ',' . $this->number;
		return $offset;
	}

}

/*$page = new Page();
var_dump($page->allPage());*/