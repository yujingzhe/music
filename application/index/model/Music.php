<?php

namespace app\index\model;
use think\Db;
use think\Model;
use think\Request;
use think\Paginate;
use traits\model\SoftDelete;

class Music extends Model
{
	
	public function getStatusAttr($value)
	{
		$status = [-1=>'删除',0=>'禁用',1=>'正常',2=>'待审核'];
		return $status[$value];
	}
        //查询歌曲列表 加歌手
        public function mulist()
	{
             $data = Db::table('bx_music')->alias('m')->where('m.delete_time','null')->join('bx_singer s','m.sid=s.sid')
                     ->limit(9)->select();
             return $data;
	}
        
         public function search()
	{
             $con = input('param.con');
             //dump($con);
             $data = Db::table('bx_music')->alias('m')->where('name','like',"%$con%")->join('bx_singer s','m.sid=s.sid')
                     ->limit(10)->select();
             return $data;
	}
        
        public function toplist()
	{
             $data = Db::table('bx_music')->alias('m')->where('m.top','1')->where('m.delete_time','null')->join('bx_singer s','m.sid=s.sid')
                     ->limit(1)->select();
             return $data;
	}
        
        public function topli()
	{
             $data = Db::table('bx_music')->alias('m')->where('m.top','1')->where('m.delete_time','null')->join('bx_singer s','m.sid=s.sid')
                     ->limit(1,9)->select();
             return $data;
	}
        
        //最新推荐
	public function lists()
	{
             $data = Db::name('music')->where('m.top','1')->alias('m')->where('m.delete_time','null')->join('bx_singer s','m.sid=s.sid')
                     ->limit(10)->select();
             return $data;
	}
        //最热推荐
        public function hit()
	{
             $data = Db::name('music')->where('m.delete_time','null')->order('m.hit','desc')->
                     alias('m')->join('bx_singer s','m.sid=s.sid')->limit(10)->select();
             //dump($data);die;
             return $data;
	}
        //好评
         public function isgood()
	{
             $data = Db::name('music')->order('good','desc')->alias('m')->where('m.delete_time','null')->join('bx_singer s','m.sid=s.sid')->limit(10)->select();
             //dump($data);die;
             return $data;
	}
        
        public function week()
	{
             $data = Db::name('music')->order('good','desc')->alias('m')
                     ->where('m.top','1')->where('m.delete_time','null')->join('bx_singer s','m.sid=s.sid')->limit(10)->select();
             //dump($data);die;
             return $data;
	}
        //歌曲详情页
        public function minfo($id)
	{
            $res = Db::table('bx_music')->where('id',$id)->setInc('hit',1);
		$data = Db::table('bx_music')->alias('m')->field('m.*,s.sname,s.sid,a.aname,c.c_name,u.username')
                        ->join('bx_singer s','m.sid=s.sid', 'left')
                        ->join('bx_album a','m.zid=a.id','left')
                        ->join('bx_cate c','m.qid=c.c_id','left')
                        ->join('bx_user u','m.u_id=u.id','left')
                        ->where('m.id',"$id")->find();
       //dump($data);die;
             return $data;
	}
        //歌曲详情页推荐歌曲
         public function mut()
	{
             $data = Db::table('bx_music')->alias('m')->join('bx_singer s','m.sid=s.sid')
                     ->field('m.id,m.name,m.music_url,s.sname,s.sid')
                     ->where('m.top','1')->where('m.delete_time','null')->limit(3)->select();
             //dump($data);die;
             return $data;
	}
        //点赞数
        public function good(){
             $id = input('param.id');
            
            $data = Db::table('bx_music')->where('id',$id)->find();
            $good = $data['good']+1;
            //dump($good);
            $res = Db::table('bx_music')->where('id',$id)->update(['good' => $good]);
            return $res;
            
        }
        
         public function bad(){
             $id = input('param.id');
            
            $data = Db::table('bx_music')->where('id',$id)->find();
           $good = $data['good'];
            if($good == 0){
                $good = 1;
            }else{
                 $good--;
            }
            //dump($good);
            $res = Db::table('bx_music')->where('id',$id)->update(['good' => $good]);
            return $res;
            
        }
        
        public function sm(){
            $id = input('param.id');
            $music = Db::table('bx_music')->alias('m')->field('m.*,u.username')->where('sid',$id)->join('bx_user u','m.u_id = u.id')->select();
            //dump($music);die;
            return $music;
        }
        //专辑所属音乐
        public function abm(){
            $id = input('param.id');
            $music = Db::table('bx_music')->alias('m')->field('m.*,u.id,u.username')->where('zid',$id)->join('bx_user u','m.u_id = u.id')->select();
            //dump($music);die;
            return $music;
        }
        
        public function cmlist()
	{
            $id = input('param.id');
             $data = Db::name('music')->alias('m')
                     ->where('m.qid',$id)->join('bx_singer s','m.sid=s.sid')->select();
             //dump($data);die;
             return $data;
	}
	
}