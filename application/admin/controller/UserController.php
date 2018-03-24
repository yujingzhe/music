<?php
namespace application\admin\controller;
use think\Loader;
class UserController extends CommonController 
{
	/**
	 * 首页遍历
	 * @return [type] [description]
	 */
	public function index()
	{	
        $info = model('User')->chaxun();
        $this->assign('info', $info);
        $page = $info->render();
       // dump($info);die;
        $this->assign('page', $page); 
		return $this->fetch();
	}
	
	/**
	 * 取消或授权VIP
	 * @return [type] [description]
	 */
	public function vip()
	{
		$id = input('id');
		$res = model('user')->quxiao($id);
		// var_dump($res);die;
		 if ($res) {
             echo "<script>alert('操作成功')</script>"; 
           echo "<script>window.location.href='index';</script>";
           exit();
           
        } else {
         
            echo "<script>alert('操作失败')</script>"; 
            echo "<script>window.history.go(-1)</script>";
            exit();
        }
	}	

	/**
	 * 取消或锁定用户
	 * @return [type] [description]
	 */
	public function lock()
	{
		$id = input('id');
		$res = model('user')->suoding($id);
		// var_dump($res);die;
		 if ($res) {
            echo "<script>alert('操作成功')</script>"; 
           echo "<script>window.location.href='index';</script>";
           exit();
           
        } else {
         
            echo "<script>alert('操作失败')</script>"; 
            echo "<script>window.history.go(-1)</script>";
            exit();
        }
	}
}