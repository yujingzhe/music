<?php

namespace application\index\model;
use think\Db;
use think\Model;
use traits\model\SoftDelete;

class Album extends Model
{
    //首页首发列表
    public function album(){
        $data = Db::name('album')->alias('a')->where('a.top','1')->where('a.delete_time','null')
                ->join('bx_singer s','a.sid=s.sid')->limit(10)->select();
                //dump($data);die;
                return $data;
    }
    public function search(){
         $con = input('param.con');
        $data = Db::name('album')->alias('a')->where('a.aname','like',"%$con%")->where('a.delete_time','null')
                ->join('bx_singer s','a.sid=s.sid')->limit(10)->select();
                //dump($data);die;
                return $data;
    }

    public function lists()
	{
                $id = input('param.id');
		$data = Db::name('album')->where('sid',$id)->select();
                //dump($data);die;
                return $data;
	}
    //歌手的其他专辑
    public function exm()
	{
                $id = input('param.id');
		$data = Db::name('album')->where('id',$id)->find();
                $sid = $data['sid'];
                $res = Db::name('album')->where('sid',$sid)->limit(8)->select();
                //dump($res);die;
                return $res;
	}
        
    public function info()
	{
                $id = input('param.id');
		$data = Db::table('bx_album')->alias('a')
                        ->join('bx_singer s','a.sid=s.sid', 'left')
                        ->join('bx_albumtype c','a.zid=c.zid','left')
                        ->join('bx_user u','a.uid=u.id','left')
                        ->where('a.id',"$id")->find();
       //dump($data);die;
             return $data;
	}
        
       
	
}