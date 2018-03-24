<?php
namespace application\admin\model;
use traits\model\SoftDelete;
use think\Db;
class Singer extends \think\Model 
{
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
    /**
     * 查询
     * @return [type] [description]
     */
    public function chaxun() 
	{
		// 查询数据集
		$info = Db::table('bx_singer')
			  ->field('bx_singer.*')
              ->where('bx_singer.delete_time','null')
              ->view('bx_singertype','name','bx_singer.class = bx_singertype.sid')
              // ->select();
              ->paginate(10);
		return $info;
	}


    /**
     * / 查询修改歌手
     * @param  [type] $data [description]
     * @return [type]       [description]
     */
    public function xginfo($data) 
    {       
        $info = Db::table('bx_singer')
               ->where('bx_singer.sid',$data)
               ->field('bx_singer.*')
               ->view('bx_singertype','name','bx_singer.class = bx_singertype.sid')
               ->select();
        return $info;
    }

    /**
     * /删除歌手
     * @param  [type] $data [description]
     * @return [type]       [description]
     */
    public function plsc($data) 
    {
        if (is_array($data)) {
            $data = implode(',',$data);           
        }
        $info = Singer::destroy($data);

        
        return $info;
    }
    
    /**
     * / 修改数据集
     * @param  [type] $data [description]
     * @return [type]       [description]
     */
    public function qfxiugai($data) 
    {   
        $info = Db::table('bx_singer')->where('sid',$data['sid'])->update($data);
        return $info;
    }

    /**
     *  添加数据
     * @param [type] $data [description]
     */
    public function add($data) 
    {   
        $info = Db::table('bx_singer')->insert($data);
        return $info;
    }


	
}