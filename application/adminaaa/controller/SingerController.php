<?php
namespace app\admin\controller;
use think\Loader;
use think\Session;
use think\Db;
class SingerController extends CommonController 
{
	/**
	 *  查询遍历
	 */
	public function index()
	{
		
		$info = model('Singer')->chaxun();
        $this->assign('info', $info);
        $page = $info->render();
       // dump($info);die;
        $this->assign('page', $page);        
		return $this->fetch();
	}

	public function add()
	{
		
		//获取修改专辑的信息
	 	$id = input('get.sid');
        if ($id) {
        	$data = model('Singer')->xginfo($id);
        	$data[0]['id'] = $id;
        	$data = $data[0];
        	// var_dump($data);die;
        	$this->assign('data', $data);  
        }
        // 歌手类型
		$type =Db::table('bx_singertype')
		      ->field(['sid','name'])
		      ->where('delete_time','null')
		      ->where('bx_singertype.sid','neq','0')
		      ->select();
		$this->assign('type', $type); 
		return $this->fetch();
	}
	


	/*
	 * 批量删除曲风 歌曲分类
	 */ 
	public function manydel()
	{
		$data = $_POST['sid'];
		if (!$data) {
			$data = input('get.sid');	// 单个删除专辑
		}
		if (!$data) {
			 echo "<script>alert('请选择删除')</script>"; 
            echo "<script>window.history.go(-1)</script>";
            exit();
		}
		// var_dump($data);die;
		$res = model('Singer')->plsc($data);
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

	/**
	 * 修改歌手
	 * @return [type] [description]
	 */
	public function xiugai()
	{
		$data = input();
		$data['uid'] = Session::get('a_id');
		$data['update_time'] = time();
		if (!$data['top']) {
			$data['top'] = 0;
		}
		// var_dump($data);die;
		$res = model('singer')->qfxiugai($data);
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


	/**
	 * 添加歌手
	 * @return [type] [description]
	 */
	public function tianjia()
	{
		$data = input();
		$data['uid'] = Session::get('a_id');
		$data['create_time'] = time();
		$res = model('singer')->add($data);
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
	 * 歌手类型
	 * @return [type] [description]
	 */
	public function singer_type() 
	{
		//	遍历	
        $info = model('Singertype')->chaxun();
        $this->assign('info', $info);
        $page = $info->render();
       // dump($info);die;
        $this->assign('page', $page); 
		return $this->fetch();
	}


	/**
	 * 歌手类型add
	 */
	public function singer_type_add() 
	{
		return $this->fetch();
	}



	/*
	 * 批量删除歌手类型
	 */ 
	public function del()
	{
		$data = $_POST['sid'];
		if (!$data) {
			$data = input('get.sid');	// 单个删除专辑
		}
		if (!$data) {
			  echo "<script>alert('请选择删除')</script>"; 
            echo "<script>window.history.go(-1)</script>";
            exit();
		}
		// var_dump($data);die;
		$res = model('Singertype')->plsc($data);
		// var_dump($res);die;
		 if ($res) {
           echo "<script>alert('删除成功')</script>"; 
           echo "<script>window.location.href='singer_type';</script>";
           exit();
           
        } else {
         
            echo "<script>alert('删除失败')</script>"; 
            echo "<script>window.history.go(-1)</script>";
            exit();
        }
	}



	/*
	 * 添加歌手类型
	 */
	public function addtype()
	{
		
		$data = input();
		$data['create_time'] = time();
		$res = model('Singertype')->add($data);
		// var_dump($data);die;
        if ($res) {
            echo "<script>alert('添加成功')</script>"; 
           echo "<script>window.location.href='singer_type';</script>";
           exit();
           
        } else {
         
            echo "<script>alert('添加失败')</script>"; 
            echo "<script>window.history.go(-1)</script>";
            exit();
        }
	}

	
}