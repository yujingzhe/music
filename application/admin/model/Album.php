<?php
namespace application\admin\model;
use traits\model\SoftDelete;
use think\Db;
class Album extends \think\Model {
	use SoftDelete;
	// protected $autoWriteTimestamp;
 	protected $autoWriteTimestamp = true;
    //默认自动写入的字段有
    //创建时间和更新时间，他们对应的字段名分别是
    //create_time,和update_time
    //也可以在model里自己设置。
    protected $createTime = 'create_time';
    protected $updateTime = 'update_time';
	protected $deleteTime = 'delete_time';

	// 查询数据集
	public function chaxun() 
	{		
		$info = Db::table('bx_album')
			   ->where('bx_album.delete_time','null')
			   ->field('bx_album.id, bx_album.aname, bx_album.dianji,bx_album.top, bx_album.pic, bx_album.create_time, bx_album.company')
			   ->view('bx_singer','sname','bx_album.sid = bx_singer.sid ')
			   ->view('bx_albumtype','name','bx_album.zid = bx_albumtype.zid ')  
		   	   // ->select();
		   	   ->paginate(10);
		return $info;
	}

	// 查询修改专辑数据
	public function xginfo($data) 
	{		
		$info = Db::table('bx_album')
			   ->where('bx_album.id',$data)
			   ->field('bx_album.sid, bx_album.aname, bx_album.zid, bx_album.top, bx_album.pic, bx_album.company,bx_album.description' )
			   ->view('bx_singer','sname','bx_album.sid = bx_singer.sid ')
			   ->view('bx_albumtype','name','bx_album.zid = bx_albumtype.zid ')  
		   	   ->select();
		return $info;
	}

	// 删除专辑 
	public function plsc($data) 
	{

		
		if (is_array($data)) {
			$data = implode(',',$data);
		}
		$info = Album::destroy($data);
		return $info;
	}

	// 插入数据集
	public function addalbum($data) 
	{		
		$info = Db::table('bx_album')->insert($data);
		return $info;
	}
	
	// 修改数据集
	public function xiugai($data) 
	{		
		$info = Db::table('bx_album')->where('id',$data['id'])->update($data);
		return $info;
	}

}