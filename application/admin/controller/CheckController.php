<?php
namespace application\admin\controller;
use app\admin\model\Music as MusicModel;
use think\Controller;
use think\Model;
use think\request;
use think\Db;
use think\Session;
use think\Loader;

class CheckController extends CommonController 
{
	/**
	 * 审核音乐
	 * @return [type] [description]
	 */
	public function music()
	{
		/* 查询条件初始化 */
        $list = model('music')->shenhe();
        			
        $page = $list->render();
       // dump($list);
        $this->assign('list', $list);
        $this->assign('page', $page);
		return $this->fetch();
	}

  /**
   * 置顶
   * @return [type] [description]
   */
  public function top()
  {
    $id = input('id');
    $res = model('music')->zhiding($id);
    // var_dump($res);die;
     if ($res) {
             echo "<script>alert('置顶成功')</script>"; 
           echo "<script>window.location.href='music';</script>";
           exit();
          
        } else {
         
            echo "<script>alert('置顶失败')</script>"; 
            echo "<script>window.history.go(-1)</script>";
            exit();
        }
  }




	/*
	 * 歌曲审核通过
	 */ 
	public function yes()
	{
		$data = $_POST['id'];
		if (!$data) {
			$data = input('get.id');	// 单个删除专辑
		}
		if (!$data) {
			 $this->error('请选择');
		}
		// var_dump($data);die;
		$res = model('Music')->tongguo($data);
		 if ($res) {
            echo "<script>alert('审核通过')</script>"; 
           echo "<script>window.location.href='music';</script>";
           exit();
          
        } else {
         
            echo "<script>alert('审核失败')</script>"; 
            echo "<script>window.history.go(-1)</script>";
            exit();
        }
	}



	/*
	 * 驳回歌曲审核
	 */ 
	public function no()
	{
		$data = $_POST['id'];
		if (!$data) {
			$data = input('get.id');	// 单个删除专辑
		}
		if (!$data) {
			 $this->error('请选择');
		}
		// var_dump($data);die;
		$res = model('Music')->bohui($data);
		 if ($res) {
             echo "<script>alert('驳回申请')</script>"; 
           echo "<script>window.location.href='music';</script>";
           exit();
          
        } else {
         
            echo "<script>alert('驳回申请失败')</script>"; 
            echo "<script>window.history.go(-1)</script>";
            exit();
        }
	}


	/**
	 * 审核MV
	 * @return [type] [description]
	 */
	public function mv()
	{

        /* 查询条件初始化 */
        $list = model('Mv')->shenhe();
        			
        $page = $list->render();
       // dump($list);
        $this->assign('list', $list);
        $this->assign('page', $page);
		return $this->fetch();
	}



  /**
   * MV置顶
   * @return [type] [description]
   */
  public function mvtop()
  {
    $id = input('id');
    $res = model('mv')->zhiding($id);
    // var_dump($res);die;
     if ($res) {
             echo "<script>alert('置顶成功')</script>"; 
           echo "<script>window.location.href='mv';</script>";
           exit();
          
        } else {
         
            echo "<script>alert('置顶失败')</script>"; 
            echo "<script>window.history.go(-1)</script>";
            exit();
        }
  }


  	/*
	 * 歌曲审核通过
	 */ 
	public function mvyes()
	{
		$data = $_POST['id'];
		if (!$data) {
			$data = input('get.id');	// 单个删除专辑
		}
		if (!$data) {
			 $this->error('请选择');
		}
		// var_dump($data);die;
		$res = model('Mv')->tongguo($data);
		 if ($res) {
            echo "<script>alert('审核通过')</script>"; 
           echo "<script>window.location.href='mv';</script>";
           exit();
          
        } else {
         
            echo "<script>alert('审核失败')</script>"; 
            echo "<script>window.history.go(-1)</script>";
            exit();
        }
	}



	/*
	 * 驳回歌曲审核
	 */ 
	public function mvno()
	{
		$data = $_POST['id'];
		if (!$data) {
			$data = input('get.id');	// 单个删除专辑
		}
		if (!$data) {
			 $this->error('请选择');
		}
		// var_dump($data);die;
		$res = model('Mv')->bohui($data);
		 if ($res) {
            echo "<script>alert('驳回成功')</script>"; 
           echo "<script>window.location.href='mv';</script>";
           exit();
          
        } else {
         
            echo "<script>alert('驳回失败')</script>"; 
            echo "<script>window.history.go(-1)</script>";
            exit();
        }
	}
}