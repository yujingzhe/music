<?php
namespace app\admin\controller;
use think\Loader;
use think\Session;
class CateController extends CommonController 
{
	/**
	 * /// 查询遍历
	 * @return [type] [description]
	 */
	public function index()
	{
		
		$info = model('Cate')->chaxun();
        $this->assign('info', $info);
        $page = $info->render();
       // dump($list);
        $this->assign('page', $page);        
		return $this->fetch();
	}

	/**
	 * 遍历添加页
	 */
	public function add()
	{
		//获取修改专辑的信息
	 	$id = input('get.cid');
        if ($id) {
        	$data = model('Cate')->xginfo($id);
        	$data[0]['id'] = $id;
        	$data = $data[0];
        	// var_dump($data);die;
        	$this->assign('data', $data);  
        }
		 //下拉菜单
	    $this->assign('selectCate', Loader::model('cate')->selectCate());
		return $this->fetch();
		
	}

	/**
	 * 添加曲风
	 * @return [type] [description]
	 */
	public function tianjia()
	{
		$data = input();
		$data['uid'] = Session::get('a_id');
		$data['create_time'] = time();
		$res = model('cate')->add($data);
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
	/**
	 * 修改曲风
	 * @return [type] [description]
	 */
	public function xiugai()
	{
		$data = input();
		$data['uid'] = Session::get('a_id');
		$data['update_time'] = time();
		// var_dump($data);die;
		$res = model('cate')->qfxiugai($data);
		// var_dump($res);die;
        if ($res) {
            echo "<script>alert('修改成功')</script>"; 
           echo "<script>window.location.href='index';</script>";
           exit();
          
        } else {
         
            echo "<script>alert('修改失败')</script>"; 
            echo "<script>window.history.go(-1)</script>";
            exit();
        }
        
	}


	/*
	 * 批量删除曲风 歌曲分类
	 */ 
	public function manydel()
	{
		$data = $_POST['cid'];
		if (!$data) {
			$data = input('get.cid');	// 单个删除专辑
		}
		if (!$data) {
			 $this->error('请选择');
		}
		// var_dump($data);die;
		$res = model('Cate')->plsc($data);
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






