<?php
namespace app\admin\controller;
use think\Loader;
use Ip2Region\Ip2Region;
class UserController extends CommonController 
{
	/**
	 * 首页遍历
	 * @return [type] [description]
	 */
	public function index()
	{	
        $info = model('User')->chaxun();
     
        // $page = $info->render();
       
        $ip2region = new Ip2Region();
        foreach ($info as $key => $value) {

	        $ip = long2Ip($value['loginip']);

	        $dizhi[$key] = $ip2region->btreeSearch($ip);
	      
	        $info[$key]['region'] = $dizhi[$key]['region'];
	       
        }     

        // var_dump($info);   
        $this->assign('info', $info);  
        // $this->assign('page', $page); 
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