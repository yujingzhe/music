<?php

namespace application\index\model;
use think\Db;
use think\Model;
use traits\model\SoftDelete;

class Mv extends Model
{
	
	
	public function lists()
	{
                $id = input('param.id');
		$data = Db::name('mv')->where('sid',$id)->limit(10)->select();
                //dump($data);die;
                return $data;
	}
        //类别列表
        public function clalist()
	{
                $id = input('param.id');
		$data = Db::name('mv')->alias('m')->where('id',$id)->
                        join('bx_singer s','s.sid = m.sid')->limit(10)->select();
                //dump($data);die;
                return $data;
	}
        
        //mv首播
        public function lie()
	{
                
		$data = Db::name('mv')->alias('m')->order('m.create_time','desc')->where('m.delete_time','null')
                        ->join('bx_singer s','s.sid = m.sid')->limit(10)->select();
                //dump($data);die;
                return $data;
	}
        //24小时热播
        public function rebo()
	{
                
		$data = Db::name('mv')->alias('m')->order('m.hit','desc')->where('m.delete_time','null')
                        ->join('bx_singer s','s.sid = m.sid')->limit(10)->select();
                //dump($data);die;
                return $data;
	}
        //mv热播
        public function top()
	{
                
		$data = Db::name('mv')->alias('m')->where('m.is_top','1')->where('m.delete_time','null')
                        ->join('bx_singer s','s.sid = m.sid')
                        ->limit(10)->select();
                //dump($data);die;
                return $data;
	}
        
        public function istop()
	{
                
		$data = Db::name('mv')->where('is_top','1')->where('m.delete_time','null')->limit(3)->select();
                //dump($data);die;
                return $data;
	}
        
        public function mvinfo()
	{
                $id = input('param.id');
		$data = Db::name('mv')->where('id',$id)->find();
                //dump($data);die;
                return $data;
	}
       
        public function search()
	{
                 $con = input('param.con');
		$data = Db::name('mv')->alias('m')->where('m_name','like',"%$con%")
                        ->join('bx_singer s','s.sid = m.sid')
                        ->limit(10)->select();
                //dump($data);die;
                return $data;
	}
	
}