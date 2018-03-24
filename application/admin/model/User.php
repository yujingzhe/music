<?php
namespace application\admin\model;
use traits\model\SoftDelete;
use think\Db;
use think\Model;
use think\Controller;
class User extends \think\Model 
{
	// 设置当前模型对应的完整数据表名称
	protected $table = 'bx_user';
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
		
		$info = Db::table('bx_user')
			  ->where('bx_user.delete_time','null')
			  ->field('bx_user.*,bx_userinfo.grade,bx_userinfo.name,bx_userinfo.address,bx_userinfo.qq,bx_userinfo.gq,bx_userinfo.tel')
			  ->join('bx_userinfo','bx_userinfo.uid = bx_user.id','left')
			  // ->select();
			  ->paginate(6);
		return $info;
	}

	/**
	 * VIP
	 */
	public function quxiao($id)
	{
		
		$user = new User;
		$data = Db::table('bx_user')->field('vip')->where('id='.$id)->find();
		
		if ($data['vip'] == 1) {
			// save方法第二个参数为更新条件
			// 取消授权VIP
			return $user->save([
				'vip' => 0
				],['id' => $id]);
			}
		  else if($data['vip'] == 0) {
			// 授权vip
			return $user->save([
				'vip' => 1
				],['id' => $id]);
			}
		
	}	

	/**
	 * 锁定或解锁用户
	 */
	public function suoding($id)
	{
		
		$user = new User;
		$data = Db::table('bx_user')->field('status')->where('id='.$id)->find();
		
		if ($data['status'] == 1) {
			// save方法第二个参数为更新条件
			// 取消解锁
			return $user->save([
				'status' => 0
				],['id' => $id]);
			}
		  else if($data['status'] == 0) {
			// 解锁
			return $user->save([
				'status' => 1
				],['id' => $id]);
			}
		
	}	
}