<?php
namespace application\admin\controller;
use think\Controller;
use app\admin\model\Album as AlbumModel;
use app\admin\model\Singer as SingerModel;
use app\admin\model\Albumtype as AlbumtypeModel;
use think\Session;
use think\Db;
use think\Model;
use think\Loader;
use think\config;
//引入七牛云的相关文件
use Qiniu\Auth as Auth;
use Qiniu\Storage\BucketManager;
use Qiniu\Storage\UploadManager;
class AlbumController extends CommonController {
	/**
	 * 首页
	 */
	public function index()
	{
	//	遍历	
        $info = model('Album')->chaxun();
        $this->assign('info', $info);
        $page = $info->render();
       // dump($info);
        $this->assign('page', $page);       
		return $this->fetch();
	}

	public function add()
	 {
	 	//获取修改专辑的信息
	 	$id = input('get.id');
        if ($id) {
        	$data = model('Album')->xginfo($id);
        	$data[0]['id'] = $id;
        	$data = $data[0];
        	// var_dump($data);die;
        	$this->assign('data', $data);  
        }
        

	 	// 首页遍历
	 	// 音乐查询
		$singer = Db::table('bx_singer')
		        ->field(['sid','sname'])
                ->where('delete_time','null')
		        ->select();
		// 专辑类型
		$type =Db::table('bx_albumtype')
		      ->field(['zid','name'])
		      ->where('delete_time','null')
		      ->select();
		$this->assign('singer', $singer);     		   
		$this->assign('type', $type);  

      	/*  $id = input('id');
        if ($id) {
            //当前用户信息
            $info = db('cate')->find($id);
            $this->assign('info', $info);
        }*/

		 //下拉菜单
        $this->assign('selectCate', Loader::model('cate')->selectCate());
		return $this->fetch();
	}


	// 添加专辑
	public function tianjia()
	{
	  $imgfile = request()->file('pic');  //接收图片
		// 上传图片
	  $filePath = $imgfile->getRealPath();  
      $ext = pathinfo($imgfile->getInfo('name'), PATHINFO_EXTENSION);  //后缀  
      // 上传到七牛后保存的文件名  
      $key =substr(md5($imgfile->getRealPath()) , 0, 5). date('YmdHis') . rand(0, 9999) . '.' . $ext;  

       // require_once "../../vendor/Qiniu/autoload.php";  
       require_once APP_PATH . '/../vendor/Qiniu/autoload.php';  
      // 需要填写你的 Access Key 和 Secret Key  
      $accessKey = Config::get('qiniu.accessKey');  
      $secretKey = Config::get('qiniu.secretKey');  

      // 构建鉴权对象  
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
      	  // var_dump($a);die;
          //返回图片的完整URL  
          // return ["err"=>0,"msg"=>"上传完成","data"=>($domain .'/'. $ret['key'])];  
          // return  "$domain .'/'. $ret['key']";
          $data['pic'] = 'http://'.$domain.'/'.$ret['key'];
      }        
		
		
		
		$data = input();
		$data['uid'] = Session::get('a_id');
		$data['create_time'] = time();
		$data['pic'] = 'http://'.$domain.'/'.$ret['key'];
		// $data['pic'] = ROOT_PATH . 'public' . DS . 'uploads\\'.$info->getSaveName();

		$res = model('album')->addalbum($data);
        if ($res) {
             echo "<script>alert('添加成功')</script>"; 
           echo "<script>window.location.href='index';</script>";
           exit();
           
        } else {
         
            echo "<script>alert('添加失败')</script>"; 
            echo "<script>window.history.go(-1)</script>";
            exit();
        }
	}

	/*
	 * 批量删除专辑
	 */ 
	public function manydel()
	{
		$data = $_POST['id'];
		if (!$data) {
			$data = $_GET['id'];	// 单个删除专辑
		}
		if (!$data) {
			 $this->error('请选择');
		}
		
		$res = model('album')->plsc($data);
		 if ($res) {
            echo "<script>alert('删除成功')</script>"; 
           echo "<script>window.location.href='index';</script>";
           exit();
          
        } else {
         
            echo "<script>alert('删除失败')</script>"; 
            echo "<script>window.history.go(-1)</script>";
            exit();
        }
	}

	
	/*
	 * 批量删除专辑类型
	 */ 
	public function typedel()
	{
		$data = $_POST['zid'];
		if (!$data) {
			$data = input('get.zid');	// 单个删除专辑
		}
		if (!$data) {
			 $this->error('请选择');
		}
		// var_dump($data);die;
		$res = model('Album_type')->plsc($data);
		// var_dump($res);die;
		 if ($res) {
            
         echo "<script>alert('删除成功')</script>"; 
           echo "<script>window.location.href='album_type';</script>";
           exit();
          
        } else {
         
            echo "<script>alert('删除失败')</script>"; 
            echo "<script>window.history.go(-1)</script>";
            exit();
	}

	

}
	/*
	 * 查询专辑类型
	 */ 
	public function album_type()
	{
		
		$info = model('Album_type')->chaxun();
        $this->assign('info', $info);      
        // var_dump($info);die;
         $page = $info->render();
       // dump($list);
        $this->assign('page', $page);       
		return $this->fetch();
	}

	/**
	 * 获取修改专辑类型的信息  遍历 添加专辑类型页面
	 * @return [type] [description]
	 */
	public function album_type_add()
	{
		//获取修改专辑的信息
	 	$zid = input('get.zid');
        if ($zid) {
        	$data = model('Album_type')->xginfo($zid);
        	$data[0]['zid'] = $zid;
        	$data = $data[0];
        	// var_dump($data);die;
        	$this->assign('data', $data);  
        }
		return $this->fetch();
	}

	/*
	 * 添加专辑类型
	 */
	public function addtype()
	{
		
		$data = input();
		$data['uid'] = Session::get('a_id');
		$data['create_time'] = time();
		$res = model('Album_type')->add($data);
		// var_dump($data);die;
        if ($res) {
            echo "<script>alert('添加成功')</script>"; 
           echo "<script>window.location.href='album_type';</script>";
           exit();
          
        } else {
         
            echo "<script>alert('添加失败')</script>"; 
            echo "<script>window.history.go(-1)</script>";
            exit();
        }
	}

	/*
     * 修改专辑
     */
    public function edit() {
       $data = input();
     	$data['uid'] = Session::get('a_id');
		$data['update_time'] = time();
		if (!$data['top']) {
			$data['top'] = 0;
		}
	  $imgfile = request()->file('pic');  //接收图片
	  if (!empty($imgfile)) {
	  	// 上传图片
	  $filePath = $imgfile->getRealPath();  
      $ext = pathinfo($imgfile->getInfo('name'), PATHINFO_EXTENSION);  //后缀  
      // 上传到七牛后保存的文件名  
      $key =substr(md5($imgfile->getRealPath()) , 0, 5). date('YmdHis') . rand(0, 9999) . '.' . $ext;  

       // require_once "../../vendor/Qiniu/autoload.php";  
       require_once APP_PATH . '/../vendor/Qiniu/autoload.php';  
      // 需要填写你的 Access Key 和 Secret Key  
      $accessKey = Config::get('qiniu.accessKey');  
      $secretKey = Config::get('qiniu.secretKey');  

      // 构建鉴权对象  
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
      	  // var_dump($a);die;
          //返回图片的完整URL  
          // return ["err"=>0,"msg"=>"上传完成","data"=>($domain .'/'. $ret['key'])];  
          // return  "$domain .'/'. $ret['key']";
          $data['pic'] = 'http://'.$domain.'/'.$ret['key'];
      } 
	  }
		
		$res = model('album')->xiugai($data);
        if ($res) {
             echo "<script>alert('修改成功')</script>"; 
           echo "<script>window.location.href='index';</script>";
           exit();
          
        } else {
         
            echo "<script>alert('修改失败')</script>"; 
            echo "<script>window.history.go(-1)</script>";
            exit();
        }
	   
    }
	/*
     * 修改专辑类型
     */
    public function edittype() {
      	$data = input();

     	$data['uid'] = Session::get('a_id');
		$data['update_time'] = time();
		// var_dump($data);die;
		
		$res = model('Album_type')->xiugai($data);
        if ($res) {
            echo "<script>alert('删除成功')</script>"; 
           echo "<script>window.location.href='album_type';</script>";
           exit();
          
        } else {
         
            echo "<script>alert('删除失败')</script>"; 
            echo "<script>window.history.go(-1)</script>";
            exit();
        }
	   
    }
}