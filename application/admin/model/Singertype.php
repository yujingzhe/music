<?php
namespace application\admin\model;
use traits\model\SoftDelete;
use think\Db;
class Singertype extends \think\Model 
{
	// 设置当前模型对应的完整数据表名称
	protected $table = 'bx_singertype';
	use SoftDelete;
 	protected $autoWriteTimestamp = true;
    protected $createTime = 'create_time';
    protected $updateTime = 'update_time';
	protected $deleteTime = 'delete_time';
	/*
	 *查询数据集
	 */
	public function chaxun() 
	{
		
		$info = Db::table('bx_singertype')
			  ->where('bx_singertype.delete_time','null')
			  // ->select();
			  ->paginate(6);
		return $info;
	}


	/**
	 * /删除歌手类型
	 * @param  [type] $data [id]
	 * @return [type]       [description]
	 */
	public function plsc($data) 
	{
		if (is_array($data)) {
			$data = implode(',',$data);
		
		}
		$info = Singertype::destroy($data);
		
		return $info;
	}


	/**
	 * /// 添加数据集
	 */
	public function add($data) 
	{
		
		$info = Db::table('bx_singertype')->insert($data);
		return $info;
	}


}