<?php
namespace app\admin\controller;
use app\admin\model\Music as MusicModel;
use think\Controller;
use think\Model;
use think\request;
use think\Db;
use think\Session;
use think\Loader;
use think\config;
//引入七牛云的相关文件
use Qiniu\Auth as Auth;
use Qiniu\Storage\BucketManager;
use Qiniu\Storage\UploadManager;
class MusicController extends CommonController 
{
	public function index()
	{
    /* 查询条件初始化 */
    $list = model('music')->chaxun();
    			
    $page = $list->render();
   // dump($list);
    $this->assign('list', $list);
    $this->assign('page', $page);
  
		return $this->fetch();
	}

	public function add()
	{
	 	//获取修改专辑的信息
	 	$id = input('get.id');
        if ($id) {
        	$data = model('Music')->xginfo($id);
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
		// 标签查询
		$bq =Db::table('bx_bqtype')
		   ->field(['bid','name'])
		   ->where('delete_time','null')
		   ->select();
		   // var_dump($bq);die;
		$this->assign('singer', $singer);     		   
		$this->assign('type', $type);  
		$this->assign('bq', $bq);  

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


	/*
	 * 批量删除 歌曲
	 */ 
	public function manydel()
	{
		$data = $_POST['id'];
		if (!$data) {
			$data = input('get.id');	// 单个删除专辑
		}
		if (!$data) {
			echo "<script>alert('请选择删除')</script>"; 
            echo "<script>window.history.go(-1)</script>";
            exit();
		}
		// var_dump($data);die;
		$res = model('Music')->plsc($data);
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


	/**
	 * 添加音乐
	 */
	public function Upload()  
  {  
      // var_dump($file);die;
 
      $file = request()->file('music');  //接收音乐

     /* $imgfile = request()->file('pic');  //接收图片*/

      if (empty($file)) {
	      echo "<script>alert('请选择音乐')</script>"; 
            echo "<script>window.history.go(-1)</script>";
            exit();
      }  
      // 要上传图片的本地路径       
      $filePath = $file->getRealPath();  

      $ext = pathinfo($file->getInfo('name'), PATHINFO_EXTENSION);  //后缀  

      // 上传到七牛后保存的文件名  
      $key =substr(md5($file->getRealPath()) , 0, 5). date('YmdHis') . rand(0, 9999) . '.' . $ext;  

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
          $data['music_url'] = $domain.'/'.$ret['key'];
      }        
      // ================音乐上传结束===================================
      // =================图片上传开====================================
      // 获取表单上传文件 例如上传了001.jpg

	    // 移动到框架应用根目录/public/uploads/ 目录下
		
	    $data = input();
      	$data['create_time'] = time();
      	$data['a_id'] = Session::get('a_id');
		 $data['music_url'] = 'http://'.$domain.'/'.$ret['key'];
		// $data['pic'] = __ROOT_PATH__ . 'public' . DS . 'uploads\\'.$info->getSaveName();
      	$res = model('music')->addmusic($data);
        if ($res) {
            echo "<script>alert('上传成功')</script>"; 
           echo "<script>window.location.href='index';</script>";
           exit();
           
        } else {
         
            echo "<script>alert('上传失败')</script>"; 
            echo "<script>window.history.go(-1)</script>";
            exit();
        }
	}

	/**
	 * 修改歌曲
	 */
	  public function edit() {
       $data = input();
     	$data['a_id'] = Session::get('a_id');
		$data['update_time'] = time();
		if (!$data['top']) {
			$data['top'] = 0;
		}

	  $file = request()->file('music');  //接收音乐
      if (!empty($file)) {
	      // 要上传图片的本地路径       
      $filePath = $file->getRealPath();  

      $ext = pathinfo($file->getInfo('name'), PATHINFO_EXTENSION);  //后缀  mp3

      // 上传到七牛后保存的文件名  
      $key =substr(md5($file->getRealPath()) , 0, 5). date('YmdHis') . rand(0, 9999) . '.' . $ext;  

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
          $data['music_url'] = 'http://'.$domain.'/'.$ret['key'];
      }

      }  
  
		// dump($domain);die;
		$res = model('music')->xiugai($data);
        if ($res) {
             echo "<script>alert('上传成功')</script>"; 
           echo "<script>window.location.href='index';</script>";
           exit();
           
        } else {
         
            echo "<script>alert('上传失败')</script>"; 
            echo "<script>window.history.go(-1)</script>";
            exit();
        }
	   
    }



  /**
   * 置顶
   * @return [type] [description]
   */
  public function top()
  {
    $id = input('id');
    $res = model('music')->zhiding($id);
    // var_dump($res);die;
     if ($res) {
            echo "<script>alert('操作成功')</script>"; 
           echo "<script>window.location.href='index';</script>";
           exit();
           
        } else {
         
            echo "<script>alert('操作失败')</script>"; 
            echo "<script>window.history.go(-1)</script>";
            exit();
        }
  }

  /**
   * 搜索
   */
  public function search()
  {

    $info = input()['info'];
    $list = model('music')->sousuo($info);
    $page = $list->render();

    $this->assign('list', $list);
    $this->assign('info', $info);
    $this->assign('page', $page);
    return $this->fetch();
  }
}