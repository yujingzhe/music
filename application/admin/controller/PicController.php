<?php
namespace application\admin\controller;
use think\Controller;
use think\Session;
use think\Loader;
use server\fileupload;
class PicController extends CommonController 
{
	/**
	 * 首页
	 */
	public function index()
	{
	 /* 查询条件初始化 */
    
		$list = model('Pic')->chaxun();     			
       $page = $list->render();
       // dump($list);
     $this->assign('list', $list);
       $this->assign('page', $page); 
  	   return $this->fetch();
	}

	/*public function show()
	{
		$list = model('Pic')->chaxun();     			
       $page = $list->render();
       $this->assign('list', $list);
       $this->assign('page', $page); 
       // dump($list);
     return  $this->fetch(); 
	}*/
	/**
	 * 删除图片
	 * @return [type] [description]
	 */
	public function delpic()
	{
		$id = input();
		
		$res = model('Pic')->plsc($id);
		 if ($res) {
           return "OK";
        } else {
        	return "KO";
        }
		// var_dump($a);
	}

	public function add()
	{
	//	遍历	
   
		return $this->fetch();
	}

/**
 * 多图上传
 * @return [type] [description]
 */
	public function upload()
	{   
    } 

}