<?php
namespace app\admin\controller;
use think\Controller;
use think\Session;
use think\Loader;
use server\fileupload;
use think\config;
//引入七牛云的相关文件
use Qiniu\Auth as Auth;
use Qiniu\Storage\BucketManager;
use Qiniu\Storage\UploadManager;
class PicController extends CommonController 
{
	/**
	 * 首页
	 */
	public function index()
	{
	 /* 查询条件初始化 */
    
		$list = model('Pic')->chaxun();     			
       $page = $list->render();
       // dump($list);
     $this->assign('list', $list);
       $this->assign('page', $page); 
  	   return $this->fetch();
	}

	/*public function show()
	{
		$list = model('Pic')->chaxun();     			
       $page = $list->render();
       $this->assign('list', $list);
       $this->assign('page', $page); 
       // dump($list);
     return  $this->fetch(); 
	}*/
	/**
	 * 删除图片
	 * @return [type] [description]
	 */
	public function delpic()
	{
		$id = input();
		
		$res = model('Pic')->plsc($id);
		 if ($res) {
           return "OK";
        } else {
        	return "KO";
        }
		// var_dump($a);
	}

	public function add()
	{
	//	遍历	
   
		return $this->fetch();
	}

/**
 * 多图上传
 * @return [type] [description]
 */
	public function upload()
	{  
	    // 图片上传处理
  
  

        // 获取表单上传文件 例如上传了001.jpg
        $imgfile = request()->file('image');

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
           $data = input();
           $data['pic'] = 'http://'.$domain.'/'.$ret['key'];
           $data['create_time'] = time();
	       $res = model('pic')->addpic($data);
	        // var_dump($data);die;
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
		



 /*       //校验器，判断图片格式是否正确
        if (true !== $this->validate(['image' => $file], ['image' => 'require|image'])) {
            $this->error('请选择图像文件');
        } else {
            // 移动到框架应用根目录/public/uploads/ 目录下
            $info = $file->move(ROOT_PATH . 'public' . DS . 'uploads');
            if ($info) {
                // 成功上传后 获取上传信息
				
                //存入相对路径/upload/日期/文件名
                $data['pic'] = DS . 'uploads' . DS . $info->getSaveName();
               
                $data['create_time'] = time();
		        $res = model('pic')->addpic($data);
		        // var_dump($data);die;
		        if ($res) {
		            echo "<script>alert('上传成功')</script>"; 
		           echo "<script>window.location.href='index';</script>";
		           exit();
		           
		        } else {
		         
		            echo "<script>alert('上传失败')</script>"; 
		            echo "<script>window.history.go(-1)</script>";
		            exit();
		        }
            } else {
                // 上传失败获取错误信息
                echo $file->getError();
            }
        
    } */
    
}
}