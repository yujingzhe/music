<?php
namespace application\admin\controller;
use think\Controller;
use think\Session;
use think\Loader;
class TagController extends CommonController 
{	
	/**
	 * 首页
	 */
	public function index()
	{
	//	遍历	
        $info = model('Tag')->chaxun();
        $this->assign('info', $info);
        $page = $info->render();
       // dump($info);
        $this->assign('page', $page); 
		return $this->fetch();
	}



	/*
	 * 添加专辑类型
	 */
	public function addtype()
	{
		
		$data = input();
		$data['create_time'] = time();
		$res = model('Tag')->add($data);
		// var_dump($data);die;
        if ($res) {
            echo "<script>alert('添加成功')</script>"; 
           echo "<script>window.location.href='index';</script>";
           exit();
           
        } else {
         
            echo "<script>alert('添加失败')</script>"; 
            echo "<script>window.history.go(-1)</script>";
            exit();
        }
	}


	/*
	 * 批量删除专辑类型
	 */ 
	public function del()
	{
		$data = $_POST['bid'];
		if (!$data) {
			$data = input('get.bid');	// 单个删除专辑
		}
		if (!$data) {
			 echo "<script>alert('请选择')</script>"; 
            echo "<script>window.history.go(-1)</script>";
            exit();
		}
		// var_dump($data);die;
		$res = model('Tag')->plsc($data);
		// var_dump($res);die;
		 if ($res) {
             echo "<script>alert('删除成功')</script>"; 
           echo "<script>window.location.href='index';</script>";
           exit();
           
        } else {
         
            echo "<script>alert('删除失败')</script>"; 
            echo "<script>window.history.go(-1)</script>";
            exit();
        }
	}


	
}