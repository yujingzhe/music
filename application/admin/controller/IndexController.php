<?php
namespace application\admin\controller;
use think\Controller;
use think\Session;
use think\Db;
class IndexController extends CommonController{
    /**
     * 后台首页
     */
    public function index()
  {
    $count=array(); 
    $count['user'] = Db::table('bx_user')->count();       //用户总数
    $count['music'] = Db::table('bx_music')->count();     //音乐总数
    $count['album'] = Db::table('bx_album')->count();     //专辑总数
    $count['singer'] = Db::table('bx_singer')->count();   //歌手总数
    //新歌
    $newSong = model('music')->newSong();

    $this->assign('count',$count);
    $this->assign('newSong',$newSong);
    return $this->fetch();
  }
    
    
}