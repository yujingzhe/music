<?php
namespace application\admin\model;
use traits\model\SoftDelete;
use think\Model;
use think\Controller;
use think\Db;
use think\Paginator;
class Pic extends \think\Model 
{
	use SoftDelete;
    protected $autoWriteTimestamp = true;
    protected $createTime = 'create_time';
    protected $updateTime = 'update_time';
    protected $deleteTime = 'delete_time';
	/**
	 * / 查询数据集
	 * @return [type] [description]
	 */
	public function chaxun()
	{
		$music = Db::table('bx_pic')
			   ->field('bx_pic.*')
			   ->where('bx_pic.delete_time',null)
			   ->where('bx_pic.status',0)
		   	   // ->select();
		   	   ->paginate(10);
		return $music;
	}


    /**
     * /删除图片
     * @param  [type] $data [description]
     * @return [type]       [description]
     */
    public function plsc($data) 
    {
       
        $info = Pic::destroy($data);
        
        return $info;
    }


}