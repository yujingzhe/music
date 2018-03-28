<?php
namespace application\admin\controller;
use think\Controller;
use think\Session;
use think\Db;
use think\helper\Time;
class IndexController extends CommonController{
    /**
     * 后台首页
     */
  public function index()
  {
   
    //php获取前天起始时间戳和结束时间戳
      
    $beginQiantina=mktime(0,0,0,date('m'),date('d')-2,date('Y'));
      
    $endQiantina=mktime(0,0,0,date('m'),date('d')-1,date('Y'))-1;

    $count=array(); 
    $count['user'] = Db::table('bx_user')->count();       //用户总数
    $count['music'] = Db::table('bx_music')->count();     //音乐总数
    $count['album'] = Db::table('bx_album')->count();     //专辑总数
    $count['singer'] = Db::table('bx_singer')->count();   //歌手总数
    $count['yesterday'] = Db::table('bx_user')->whereTime('update_time','between', Time::yesterday())->count();   //昨天总数
    $count['qiantian'] = Db::table('bx_user')->whereTime('update_time','between', [$beginQiantina, $endQiantina])->count();   //前天总数
    $count['today'] = Db::table('bx_user')->whereTime('update_time','between', Time::today())->count();   //今天总数
    //新歌
    $newSong = model('music')->newSong();
    // var_dump($count);
    // var_dump(date("Y-m-d"));die;
    // var_dump(time()-86400);die;
    $this->assign('count',$count);
    $this->assign('newSong',$newSong);
    return $this->fetch();
  }
    
    
}