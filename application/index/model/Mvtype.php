<?php

namespace application\index\model;
use think\Db;
use think\Model;
use traits\model\SoftDelete;

class Mvtype extends Model
{
	
	
	public function cate()
	{
		$data = Db::name('mvtype')->where('delete_time','null')->select();
                //dump($data);die;
                return $data;
	}
        
         public function lists()
	{
                
		$data = Db::name('mv')->alias('m')->where('m.delete_time','null')
                        ->join('bx_singer s','s.sid = m.sid')
                        ->limit(10)->select();
                dump($data);die;
                return $data;
	}
	
}