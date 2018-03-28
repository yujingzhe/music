<?php
namespace application\index\controller;
use application\index\model\User as UserModel;
use think\Controller;
use think\Validate;
use think\Session;
use think\Request;
use sina\SaeTOAuthV2;
use sina\SaeTClientV2;
use server\fileupload;
use think\config;
//引入七牛云的相关文件
use Qiniu\Auth as Auth;
use Qiniu\Storage\BucketManager;
use Qiniu\Storage\UploadManager;
class User extends Controller
{
	protected $user;
	public function _initialize()
	{
		 $link = model('link')->clink();
        $this->assign('link',$link);
	}
	
	public function fenye()
	{
		$list = $this->user->paginate(1);
		$page = $list->render();
		$this->assign('list', $list);
		$this->assign('page', $page);
		return $this->fetch();
	}
        public function login()
        {
            
            return $this->fetch();
        }
        
        public function callback(){
            $o = new SaeTOAuthV2( WB_AKEY , WB_SKEY );
            $keys = array();
            $param = Request::instance()->param();
            $keys['code'] = $param['code'];
            $keys['redirect_uri'] = WB_CALLBACK_URL;
            $token = $o->getAccessToken( 'code', $keys );
            if($token){
                Session::set('token',$token);
                 $o = new SaeTClientV2( WB_AKEY , WB_SKEY ,Session::get('token')['access_token']);
                    $ms = $o->home_timeline();
                    $uid_get = $o->get_uid();
                    $uid = $uid_get['uid'];
                    $user_message = $o->show_user_by_id($uid);
                    $name = $user_message['screen_name'];
                    
                    $status = model('user')->doinsert($name,$uid);
                    if($status == 1){
//                      return $this->redirect('http://www.summer.com/index/index/index.html');
                        echo("<script language='javascript'>window.top.location.href='/index/index'</script>");
                    }else{
                       return $this->error('登录失败','User/login');
                    }
                    
            }else{
                return $this->error('授权失败');
            }
        }
      
        public function dologin()
        {
            $name =input('param.name');
            $pwd = input('param.pwd');
            //$pwd = md5(md5($pwd));
            $status = model('user')->check($name,$pwd); 

            $validate = new Validate([
			'captcha|验证码'=>'require|captcha'
		]);
		$data = [
			'captcha' => input('param.code')
		];
		if ($status == 3) {
			if(!$validate->check($data)){
				$status = 4;    
			};
		}
            $ip = $this->request->ip();
            $ip = ip2long($ip);
            $id = session('id');
            // return $pwd;
            $a = db('user')->where('id',$id)->update(['loginip' => $ip]);
            return $status;
            
        }
        public function logout()
        {
           Session::delete('name');
           $this->success('退出成功','Index/index');
        }
         public function register()
        {
            return $this->fetch();
        }
        //注册
         public function doregister()
        {
            $name =input('param.name');
            $pwd = input('param.pwd');
            $email = input('param.email');
            //$pwd = md5(md5($pwd));
            $status = model('user')->doregister($name,$pwd,$email); 
            return $status;
        }
        //检查用户名是否存在
        public function docheck()
	{
            $name =input('param.name');
            $status = model('user')->checkname($name);
            return $status;
	}
        //检查邮箱是否存在
        public function check()
	{
            $email =input('param.email');
            $name =input('param.name');
            $status = model('user')->checkemail($email,$name);
            return $status;
	}
        public function dorepass()
        {
            $pwd = input('param.pwd');
            $email = input('param.email');
            //$pwd = md5(md5($pwd));
            $status = model('user')->dorepass($pwd,$email); 
            return $status;
        }
        
         public function login_frame()
        {

            $o = new SaeTOAuthV2( WB_AKEY , WB_SKEY );
            $code_url = $o->getAUthorizeURL(WB_CALLBACK_URL) ;
            $this->assign('code_url',$code_url);
            return $this->fetch();
        }
         public function lostpasswd()
        {
            return $this->fetch();
        }
        
        public function people()
        {
            return $this->fetch();
        }
        public function userinfo()
        {
            $res = model('userinfo')->info();
            //dump($res);
            $this->assign('info',$res);
            return $this->fetch();
        }
        
        public function doinfo()
        {
            
            $res = model('userinfo')->doinfo();
            if($res){
                $this->success('修改成功');
            }else{
                $this->error('修改失败');
            }
        }
        
        public function usersong()
        {
            $res = model('like')->lists();
            $count = count($res);
            $this->assign('count',$count);
            $this->assign('res',$res);
            return $this->fetch();
        }
        
         public function repassword()
        {
            $res = model('userinfo')->info();
            //dump($res);
            $this->assign('info',$res);
            return $this->fetch();
        }


        public function dopic()
        {  
            // var_dump(session('id'));die;
        $imgfile = request()->file('pic');
        // var_dump($imgfile);die;
        $filePath = $imgfile->getRealPath();  
        $ext = pathinfo($imgfile->getInfo('name'), PATHINFO_EXTENSION);  //后缀  
        // 上传到七牛后保存的文件名  
        $key =substr(md5($imgfile->getRealPath()) , 0, 5). date('YmdHis') . rand(0, 9999) . '.' . $ext;  
        require_once APP_PATH . '/../vendor/Qiniu/autoload.php';  
        $accessKey = Config::get('qiniu.accessKey');  
        $secretKey = Config::get('qiniu.secretKey');  
        $auth = new Auth($accessKey, $secretKey); 

        // 要上传的空间  
        $bucket = Config::get('qiniu.bucket');  
        $domain = Config::get('qiniu.DOMAIN');  
        $token = $auth->uploadToken($bucket);  
        // 初始化 UploadManager 对象并进行文件的上传  
        $uploadMgr = new UploadManager();  

        // 调用 UploadManager 的 putFile 方法进行文件的上传  
        $a = list($ret, $err) = $uploadMgr->putFile($token, $key, $filePath);  

        if ($err !== null) {  
          echo "<script>alert('上传失败')</script>"; 
            echo "<script>window.history.go(-1)</script>";
            exit();
        } else {  
        $data['pic'] = 'http://'.$domain.'/'.$ret['key'];
           
        $res = model('user')->tx($data);
            // var_dump($res);die;
        if($res){
            $this->success('修改成功');
        }else{
                $this->error('修改失败');
            }
        }  
    }

}
