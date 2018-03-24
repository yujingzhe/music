<?php
namespace application\admin\model;
use traits\model\SoftDelete;
use think\Model;
use think\Controller;
use think\Db;
use think\Paginator;
class Music extends \think\Model 
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
		$music = Db::table('bx_music')
			   ->field('bx_music.id, bx_music.name,bx_music.like, bx_music.ispay,bx_music.good, bx_music.down, bx_music.hit, bx_music.top, bx_music.update_time, bx_music.music_url')
               ->where('bx_music.delete_time',null)
			   ->where('bx_music.check',1)
			   ->view('bx_singer','sname','bx_music.sid = bx_singer.sid ')
			   ->view('bx_album','aname','bx_music.zid = bx_album.id')
			   ->view('bx_cate','c_name','bx_music.qid = bx_cate.c_id')
		   	   // ->select();
		   	   ->paginate(10);
		return $music;
	}

    /**
     * / 查询新增数据集
     * @return [type] [description]
     */
    public function newSong()
    {
        $music = Db::table('bx_music')
               ->field('bx_music.name,bx_music.create_time, bx_music.music_url')
               ->where('bx_music.delete_time',null)
               ->where('bx_music.check',1)         
               ->order('id desc')
               ->limit(6)
               ->select();
        return $music;
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
        $info = Music::destroy($data);
        
        return $info;
    }


    /**
     * 添加歌曲
     */
    public function addmusic($data) 
    {       
        $info = Db::table('bx_music')->insert($data);
        return $info;
    }


    // 查询修改专辑数据
    public function xginfo($data) 
    {       
        $info = Db::table('bx_music')
               ->where('bx_music.id',$data)
               ->field('bx_music.sid, bx_music.name, bx_music.zid, bx_music.top, bx_music.m_text, bx_music.ispay, bx_music.bid,bx_music.qid, a.name aname,b.name bname,bx_singer.sname,bx_cate.c_name' ) 
               ->join('bx_singer','bx_music.sid = bx_singer.sid ', 'right')
               ->join('bx_albumtype a','bx_music.zid = bx_albumtype.zid ') 
               ->join('bx_cate ','bx_music.qid = bx_cate.c_id ') 
               ->join('bx_bqtype b','bx_music.bid = bx_bqtype.bid ') 
               ->select();
        return $info;
    }

    // 修改数据集
    public function xiugai($data) 
    {       
        $info = Db::table('bx_music')->where('id',$data['id'])->update($data);
        return $info;
    }

    /**
     * 置顶
     */
    public function zhiding($id)
    {
        
        $user = new Music;
        $data = Db::table('bx_music')->field('top')->where('id='.$id)->find();
        
        if ($data['top'] == 1) {
            // save方法第二个参数为更新条件
            // 取消解锁
            return $user->save([
                'top' => 0
                ],['id' => $id]);
            }
          else if($data['top'] == 0) {
            // 解锁
            return $user->save([
                'top' => 1
                ],['id' => $id]);
            }
        
    }

     /**
     * / 待审核查询数据集
     * @return [type] [description]
     */
    public function shenhe()
    {
        $music = Db::table('bx_music')
               ->field('bx_music.id, bx_music.name, bx_music.top, bx_music.create_time, bx_music.music_url')
               ->where('bx_music.delete_time',null)
               ->where('bx_music.check',0)
               ->view('bx_user','username','bx_music.u_id = bx_user.id','left')
               ->view('bx_admin','username admin','bx_music.a_id = bx_admin.id','left')
               // ->view('bx_cate','c_name','bx_music.qid = bx_cate.c_id')
               // ->select();
               ->paginate(10);
        return $music;
    }

    // 审核通过

    public function tongguo($data) 
    {
        if (is_array($data)) {

            foreach ($data as $key => $value) {
                 $info =Db::table('bx_music')->where('id',$value)->update(['check' => 1]);
        
                    
            }return $info;
        }
        $info =Db::table('bx_music')->where('id',$data)->update(['check' => 1]);
        
        return $info;
    }

    

    // 审核没通过

    public function bohui($data) 
    {

        $info =Db::table('bx_music')->where('id',$data)->update(['check' => 2]);
        
        return $info;
    }

    

}