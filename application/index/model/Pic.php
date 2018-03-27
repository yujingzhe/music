<?php

namespace app\index\model;
use think\Db;
use think\Model;


class Pic extends Model
{
	
	public function piclist()
	{
		$data = Db::name('pic')->where('status',0)->where('delete_time','null')->select();
                return $data;
	}
        
       
}