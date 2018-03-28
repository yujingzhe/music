<?php

namespace application\index\model;
use Think\Db;
use think\Model;
use think\Session;
use traits\model\SoftDelete;

class Userinfo extends Model
{
    
    public function info()
    {
        $id = Session::get('id');
        //dump($id);
        $res = Db::table('bx_userinfo')->where('uid',$id)->find();
        return $res;
        
    }

    public function doinfo()
        {   
            $data =input('param.');
            $id = Session::get('id');
            $data['uid'] = $id;
            $re = Db::table('bx_userinfo')->where('uid',$id)->find();
            if($re){
                
                $res = Db::table('bx_userinfo')->where('uid',$id)->update($data);
                return $res;
            }else{
                $res = Db::table('bx_userinfo')->insert($data);
                return $res;
            }
            
            //dump($data);
            //$res = Db::table('bx_userinfo')->insert($data);
        }
}