<?php

namespace application\index\model;
use think\Db;
use think\Model;
use traits\model\SoftDelete;

class Singertype extends Model
{
	
	
	public function lists()
	{
		$data = Db::name('singertype')->where('delete_time','null')->select();
                return $data;
	}
	
}