<?php
namespace app\admin\model;
use traits\model\SoftDelete;
use think\Model;
use think\Controller;
use think\Db;
use think\Paginator;
class Mv extends \think\Model 
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
	 * / 查询数据集
	 * @return [type] [description]
	 */
	public function chaxun()
	{
		$mv = Db::table('bx_mv')
			   ->field('bx_mv.*')
         ->where('bx_mv.delete_time',null)
			   ->where('bx_mv.check',1)
			   ->view('bx_singer','sname','bx_mv.sid = bx_singer.sid ')
			   ->view('bx_mvtype','mv_name','bx_mv.cate = bx_mvtype.id')
			   // ->view('bx_cate','c_name','bx_music.qid = bx_cate.c_id')
		   	   // ->select();
		   	   ->paginate(10);
		return $mv;
	}

    /**
     * /删除曲风
     * @param  [type] $data [description]
     * @return [type]       [description]
     */
    public function plsc($data) 
    {
        if (is_array($data)) {
            $data = implode(',',$data);
 
        }
        $info = Mv::destroy($data);
        
        return $info;
    }


    /**
     * 添加歌曲
     */
    public function addmusic($data) 
    {       
        $info = Db::table('bx_mv')->insert($data);
        return $info;
    }


    // 查询修改专辑数据
    public function xginfo($data) 
    {       
        $info = Db::table('bx_mv')
               ->where('bx_mv.id',$data)
               ->field('bx_mv.*,bx_singer.sname,bx_mvtype.mv_name' ) 
               ->join('bx_singer','bx_mv.sid = bx_singer.sid ', 'right')
               ->join('bx_mvtype','bx_mv.cate = bx_mvtype.id ') 
               ->select();
        return $info;
    }

    // 修改数据集
    public function xiugai($data) 
    {       
        $info = Db::table('bx_mv')->where('id',$data['id'])->update($data);
        return $info;
    }

    /**
     * 置顶
     */
    public function zhiding($id)
    {
        
        $user = new Mv;
        $data = Db::table('bx_mv')->field('is_top')->where('id='.$id)->find();
        
        if ($data['is_top'] == 1) {
            // save方法第二个参数为更新条件
            // 取消解锁
            return $user->save([
                'is_top' => 0
                ],['id' => $id]);
            }
          else if($data['is_top'] == 0) {
            // 解锁
            return $user->save([
                'is_top' => 1
                ],['id' => $id]);
            }
        
    }

    /**
     * / 查询数据集
     * @return [type] [description]
     */
    public function shenhe()
    {
        $mv = Db::table('bx_mv')
               ->field('bx_mv.*')
               ->where('bx_mv.delete_time',null)
               ->where('bx_mv.check',0)
               ->view('bx_user','username','bx_mv.uid = bx_user.id','left')
               ->view('bx_admin','username admin','bx_mv.a_id = bx_admin.id','left')
         
               // ->select();
               ->paginate(10);
        return $mv;
    }


    // 审核通过

    public function tongguo($data) 
    {
        if (is_array($data)) {

            foreach ($data as $key => $value) {
                 $info =Db::table('bx_mv')->where('id',$value)->update(['check' => 1]);
        
                    
            }return $info;
        }
        $info =Db::table('bx_mv')->where('id',$data)->update(['check' => 1]);
        
        return $info;
    }

    

    // 审核没通过

    public function bohui($data) 
    {

        $info =Db::table('bx_mv')->where('id',$data)->update(['check' => 2]);
        
        return $info;
    }

    /**
     * / 查询数据集
     * @return [type] [description]
     */
    public function sousuo($info)
    {
        $mv = Db::table('bx_mv')
                ->field('bx_mv.*')
                ->where('bx_mv.delete_time',null)
                ->where('bx_mv.check',1)
                ->where('bx_mv.m_name','like','%'.$info.'%')
                ->view('bx_singer','sname','bx_mv.sid = bx_singer.sid ')
                ->view('bx_mvtype','mv_name','bx_mv.cate = bx_mvtype.id')
               // ->view('bx_cate','c_name','bx_music.qid = bx_cate.c_id')
               // ->select();
               ->paginate(10);
        return $mv;
    }

}