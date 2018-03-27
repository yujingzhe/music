<?php

namespace app\index\model;
use think\Db;
use think\Model;
use traits\model\SoftDelete;

class Albumtype extends Model
{
	
	
	public function lists()
	{
		$data = Db::name('albumtype')->where('delete_time','null')->select();
                //dump($data);die;
                return $data;
	}
        
        public function album(){
            
        $data = Db::name('album')->alias('a')
                ->join('bx_singer s','a.sid=s.sid')->where('a.delete_time','null')->select();
                //dump($data);die;
                return $data;
        }
        
        public function albumlimit($limit){
            
        $data = Db::name('album')->alias('a')
                ->join('bx_singer s','a.sid=s.sid')->where('a.delete_time','null')->limit($limit)->select();
                //dump($data);die;
                return $data;
        }
        //根据id查找专辑
        public function albumtip(){
            $id = input('param.id');
        $data = Db::name('album')->alias('a')->where('zid',$id)
                ->join('bx_singer s','a.sid=s.sid')->select();
                //dump($data);die;
                return $data;
        }
	
}