<?php

namespace application\index\model;
use think\Db;
use think\Model;
use traits\model\SoftDelete;

class Singer extends Model
{
	
	public function tsinger()
	{
		$data = Db::name('singer')->where('top','1')->where('delete_time','null')->select();
		
                return $data;
	}
	public function lists()
	{
		$data = Db::name('singer')->where('delete_time','null')->select();
                return $data;
	}
        
        public function sinlist()
	{
            $id = input('param.id');
		$data = Db::name('singer')->where('class',$id)->select();
                return $data;
	}
        
        public function sinfo()
	{
            $id = input('param.id');
		$data = Db::table('bx_singer')->alias('m')
                        ->join('bx_album a','m.sid=a.sid','left')
                        ->where('m.sid',"$id")->find();
                
                return $data;
	}
        
         public function search()
	{
             $con = input('param.con');
             //dump($con);
             $data = Db::table('bx_singer')->alias('m')->where('sname','like',"%$con%")
                     ->limit(10)->select();
             return $data;
	}
	
}