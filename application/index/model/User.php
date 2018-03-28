<?php

namespace application\index\model;
use Think\Db;
use think\Model;
use think\Session;
use traits\model\SoftDelete;

class User extends Model
{
    //登录验证
	public function check($name='',$pwd='')
        {
           
            $data = Db::table('bx_user')->where('username',"$name")
                     ->find();
            
            if(!$data){
                return 1;
                //用户名不存在
            }
            if($pwd != $data['password']){
                return 2;
                //密码错误
            }
           
            $res = Db::table('bx_user')->where('username',"$name")
                     ->setInc('gold',5);
             $data = Db::table('bx_user')->where('username',"$name")
                     ->find();
             //dump($data);die;
            Session::set('id',$data['id']);
            Session::set('name',$data['username']);
            Session::set('email',$data['email']);
            Session::set('vip',$data['vip']);
            Session::set('pic',$data['pic']);
            Session::set('gold',$data['gold']);
            return 3;
            
        }
        public function checkname($name)
        {
           
            $data = Db::table('bx_user')->where('username',"$name")
                     ->find();
            if($data){
                //用户名存在
                return 1;
            }else{
                return 2;
            }
        }
        
        public function checkemail($email,$name)
        {
           
            $data = Db::table('bx_user')->where('email',"$email")->where('username',$name)
                     ->find();
            if($data){
                //邮箱存在
                return 1;
            }else{
                return 2;
            }
        }
        
         public function doregister($name,$pwd,$email='')
        {
             $ip = $_SERVER['REMOTE_ADDR'];
            $data = ['username' => "$name", 'password' => $pwd, 'email' => $email, 'regip' =>$ip];
            $data = Db::table('bx_user')->insert($data);

            if($data){
                //注册成功
                return 1;
            }else{
                return 2;
            }
        }
        
         public function doinsert($name,$uid)
        {
             $data = Db::table('bx_user')->where('password',$uid)
                     ->find();
             if($data){
                 $res = Db::table('bx_user')->where('username',"$name")
                     ->setInc('gold',5);
                 $data = Db::table('bx_user')->where('username',"$name")
                             ->find();
                  Session::set('id',$data['id']);
                           Session::set('name',$data['username']);
                           Session::set('email',$data['email']);
                           Session::set('vip',$data['vip']);
                           Session::set('pic',$data['pic']);
                           Session::set('gold',$data['gold']);
                 return 1;
             }else{
                 $ip = $_SERVER['REMOTE_ADDR'];
                    $data = ['username' => "$name", 'password' => $uid, 'regip' =>$ip];
                    $data = Db::table('bx_user')->insert($data);

                    if($data){
                        $res = Db::table('bx_user')->where('username',"$name")
                     ->setInc('gold',5);
                        $data = Db::table('bx_user')->where('username',"$name")
                             ->find();
                            //dump($data);die;
                           Session::set('id',$data['id']);
                           Session::set('name',$data['username']);
                           Session::set('email',$data['email']);
                           Session::set('vip',$data['vip']);
                           Session::set('pic',$data['pic']);
                           Session::set('gold',$data['gold']);
                           return 1;
                    }else{
                        return 2;
                    }
             }
             
        }
        //修改密码
        public function dorepass($pwd,$email)
        {
            
           
            $data = Db::table('bx_user')->where('email',$email)->update(['password' => $pwd]);

            if($data){
                //修改成功
                return 1;
            }else{
                return 2;
            }
        }
        
       //修改头像
        public function tx($pic)
        {
            
           $id = session('id');
            $data = Db::table('bx_user')->where('id',$id)->update(['pic' => $pic['pic']]);
            // var_dump($pic);die;
            return $data;
            
        }
        
       
	
}