<?php
namespace app\admin\model;
use traits\model\SoftDelete;
use think\Db;
class Link extends \think\Model 
{
	// 设置当前模型对应的完整数据表名称
	protected $table = 'bx_link';
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
		
		$info = Db::table('bx_link')
			  ->where('bx_link.delete_time','null')
			  // ->select();
			  ->paginate(6);
		return $info;
	}


	/**
	 * /// 添加数据集
	 */
	public function add($data) 
	{
		
		$info = Db::table('bx_link')->insert($data);
		return $info;
	}


	/**
	 * 查询修改友链数据
	 * @param  [type] $data [description]
	 * @return [type]       [description]
	 */
	public function xginfo($data) 
	{		
		$info = Db::table('bx_link')
			   ->where('bx_link.id',$data)
			   ->field(' bx_link.name, bx_link.url')
		   	   ->select();
		return $info;
	}

	/**
	 * /删除标签
	 * @param  [type] $data [id]
	 * @return [type]       [description]
	 */
	public function plsc($data) 
	{
		if (is_array($data)) {
			$data = implode(',',$data);
		
		}
		$info = Link::destroy($data);
		
		return $info;
	}


}