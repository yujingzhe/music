<?php
namespace application\admin\model;
use traits\model\SoftDelete;
use think\Db;
class AlbumType extends \think\Model 
{
	// 设置当前模型对应的完整数据表名称
	protected $table = 'bx_albumtype';
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
	/*
	 *查询数据集
	 */
	public function chaxun() 
	{
		
		$info = Db::table('bx_albumtype')
			  ->where('bx_albumtype.delete_time','null')
			  // ->select();
			  ->paginate(10);
		return $info;
	}

	/**
	 * /// 添加数据集
	 */
	public function add($data) 
	{
		
		$info = Db::table('bx_albumtype')->insert($data);
		return $info;
	}

	/**
	 * /删除专辑
	 * @param  [type] $data [id]
	 * @return [type]       [description]
	 */
	public function plsc($data) 
	{
		if (is_array($data)) {
			$data = implode(',',$data);
		
		}
		$info = Albumtype::destroy($data);
		
		return $info;
	}


	/**
	 * 查询修改专辑数据
	 * @param  [type] $data [description]
	 * @return [type]       [description]
	 */
	public function xginfo($data) 
	{		
		$info = Db::table('bx_albumtype')
			   ->where('bx_albumtype.zid',$data)
			   ->field('bx_albumtype.description, bx_albumtype.name')
		   	   ->select();
		return $info;
	}

	
	/**
	 * / 修改数据集
	 * @param  [type] $data [description]
	 * @return [type]       [description]
	 */
	public function xiugai($data) 
	{		
		$info = Db::table('bx_albumtype')->where('zid',$data['zid'])->update($data);
		return $info;
	}


	
}