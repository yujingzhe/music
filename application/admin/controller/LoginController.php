<?php
namespace application\admin\controller;

use think\Controller;
use think\Loader;
use think\Validate;
use think\Session;
use phpmailer\phpmailer; 
class LoginController extends Controller {


    /**
     * 登出
     */
    public function logout() {
        
        session('a_name', null);
        session('a_id', null);
        cookie('a_name', null);
        cookie('a_id', null);

        echo "<script>window.location.href='index';</script>";
        exit();
    }


           
       
         
            


    /**
     * 首页遍历
     * @return [type] [description]
     */
    public function index()
    {
        if (session('a_name')) {
                // $this->success('您已登入', 'index/index',0);
                 echo "<script>alert('您已登陆')</script>"; 
                   $this->redirect('index/index');
                   // header('location:reg.php');
                   // exit();
            }

        if (cookie('a_name')) {
                $username = encry_code(cookie('a_name'),'DECODE');
                $info = db('admin')->field('id,username,password')->where('username', $username)->find();
                if ($info) {
                    //记录
                    session('a_name', $info['username']);
                    session('a_id', $info['id']);
                    Loader::model('Admin')->editInfo(1, $info['id']);
                    // $this->success('登入成功', 'index/index',0);
                     echo "<script>alert('已登录')</script>"; 
                     $this->redirect('index/index');
                   // echo "<script>window.location.href='index';</script>";
                   // exit();
                }
            }
         return $this->fetch('login');
    }

// =============================================================

    public function dologin()
    {   
         
        // 接受数据
        $name =input('post.name');
        $remember =input('post.islogin');
        $pwd = input('post.pwd');
        // $pwd = md5(md5($pwd));
        $pwd = md5($pwd);
        // 身份验证
        // return $name . $remember.$pwd;
  // 验证码验证  //4验证码不正确 1 用户名不存在 2 密码错误 
        $validate = new Validate([
            'captcha|验证码'=>'require|captcha'
        ]);
        $data = [
            'captcha' => input('post.code')
        ];    
        if(!$validate->check($data)){
                $status = 4;   
                return $status; 
        };

        $status =model('Admin')->chaxun($name,$pwd);    
        // 返回值
       
        if ($status == 3) {
            $info = db('admin')->field('id,username,password')->where('username', $name)->find();
            session('a_name', $info['username']);
            session('a_id', $info['id']);

            if ($remember == 'OK') {
               
                cookie('a_name', encry_code($info['username']));
                cookie('a_id', encry_code($info['id']));
            }
            //记录登录信息
            
            Loader::model('Admin')->editInfo(1, $info['id']);
            // $this->success('登入成功', 'index/index');
        }
        return $status;
        
    }



    // 发送邮箱验证码
    public function send() {
        
        // 验邮箱格式证
        $validate = new Validate([
            'email' => 'email',
        ]);
        $data = [
            'email' => input('post.email')
        ];

        if(!$validate->check($data)){
                return $status = 5; //邮箱格式不正确
        };

        $name =input('post.name');
        $email = input('post.email');
        // return $name.$email;
        // 身份验证
        
        $a = model('Admin')->chaxun($name,$email);
        // return $a;
        if ($a == 1) {
            return $a;
        }else if($a == 2) {
            return $a;
        }else if ($a == 6) {
            $subject='半夏音乐会员找回密码';
            $str =mt_rand(100000, 999999);
            $content="尊敬的半夏会员，本次的验证码是 $str 请勿转告他人，祝生活愉快";
            $res = sendMail($email,$subject,$content);
            if ($res) {
                Session::set('str',$str);
            }
        }
            
    }


         // 找回密码
    
    public function findmima() {
        
        $yzm = input('post.code');
        // return $yzm;
        // 判断密码格式   
        $validate = new Validate([
            'xpwd' => 'require|alphaDash',
        ]);
        $data = [
            'xpwd' => input('post.xpwd')
        ];
        // return input('post.xpwd');
        if(!$validate->check($data)){
                return 9; //密码格式不正确
        };
        // 判断验证码是否正确
        if ($yzm == Session::get('str')) {

            $name =input('post.name');
            $xpwd = input('post.xpwd');
       
            // $dta['password'] = md5(md5($xpwd));     
            $dta['password'] = md5($xpwd);     
           
                   
            $xiugai = model('Admin')->forget($name,$dta);
            
            return 10;
        } else {
            return 11;  //验证码错误
        }
    }
    
    
    /**
     * 登入
     */
/*    public function index() {
        //dump(request()->ip());exit;


        if ($_POST['dosubmit']) {
            $username = input('post.username');
            $password = input('post.password');

            if (!$username) {
                $this->error('用户名不能为空');
            }
            if (!$password) {
                $this->error('密码不能为空');
            }

            $info = db('admin')->field('id,username,password')->where('username', $username)->find();

            if (!$info) {
                $this->error('用户不存在');
            }

            if (md5($password) != $info['password']) {
                $this->error('密码不正确');
            } else {
                session('a_name', $info['username']);
                session('a_id', $info['id']);
                if (input('post.islogin')) {
                    cookie('a_name', encry_code($info['username']));
                    cookie('a_id', encry_code($info['id']));
                }

                //记录登录信息
                Loader::model('Admin')->editInfo(1, $info['id']);
                $this->success('登入成功', 'index/index');
            }
        } else {
            if (session('a_name')) {
                $this->success('您已登入', 'index/index');
            }

            if (cookie('a_name')) {
                $username = encry_code(cookie('a_name'),'DECODE');
                $info = db('admin')->field('id,username,password')->where('username', $username)->find();
                if ($info) {
                    //记录
                    session('a_name', $info['username']);
                    session('a_id', $info['id']);
                    Loader::model('Admin')->editInfo(1, $info['id']);
                    $this->success('登入成功', 'index/index');
                }
            }

            $this->view->engine->layout(false);
            return $this->fetch('login');
        }
    }*/

}
