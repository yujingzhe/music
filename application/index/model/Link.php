<?php

namespace application\index\model;
use think\Db;
use think\Model;


class Link extends Model
{
	
	public function clink()
	{
		$data = Db::name('link')->where('delete_time','null')->select();
                return $data;
	}
        
       
}