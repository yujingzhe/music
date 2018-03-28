<?php

namespace application\index\model;
use think\Db;
use think\Model;
use think\Session;
use traits\model\SoftDelete;

class Like extends Model
{
    //判断是否已收藏
    public function islike($id){
        $uid = Session::get('id');
       // dump($id);
        $res = Db::table('bx_like')->where('l_uid',$uid)->find();
        if($res){
            $str = $res['l_mid'];
           
            $result = explode(',', $str);
           
            foreach ($result as $v){
                
                if($v == $id){
                    //echo 123;
                    return 1;
                }
                        
            }
        }else{
            return 0;
        }
    }

        public function addlike()
    {
        $newmid =input('param.id');
        $uid = Session::get('id');
        $res = Db::table('bx_like')->where('l_uid',$uid)->find();
        if($res){
            
            $mid = $res['l_mid'];
            $mid .= ','.$newmid; 
            //dump($mid);
            $data['l_uid'] = $uid;
            $data['l_mid'] = $mid;
           // dump($data);
            $add = Db::table('bx_like')->where('l_uid',$uid)->update($data);
            return $add;
        }else{
            
            $data['l_uid'] = $uid;
            $data['l_mid'] = $newmid;
            $add = Db::table('bx_like')->insert($data);
            return $add;
        }
        //dump($newmid);
        //dump($uid);
        
    }
    
    public function dellike(){
        $newmid =input('param.id');
        $uid = Session::get('id');
        $add = Db::table('bx_like')->where('l_uid',$uid)->find();
        $res = $add['l_mid'];
        //dump($newmid);
         $result = explode(',', $res);
         //dump($result);
            foreach ($result as $key => $v){
                if($v == $newmid){
                    //echo 123;
                    unset($result[$key]);
                }
                        
            }
            $result = implode(',', $result);
            
           $add = Db::table('bx_like')->where('l_uid',$uid)->update(['l_mid' => "$result"]);
           return $add;
    }
    //我的收藏
    public function lists(){
        $uid = Session::get('id');
        $res = Db::table('bx_like')->where('l_uid',$uid)->find();
        
        if($res){
            $a = $res['l_mid'];
            $arr = explode(',', $a);
            $data= array();
            foreach ($arr as $v){
                $add = Db::table('bx_music')->alias('m')->where('m.id',$v)
                        ->join('bx_singer s','m.sid=s.sid')->find();
               
                $data[]=$add;
            }
            return $data;
        }else{
            return 0;
        }
    }
	
	
}