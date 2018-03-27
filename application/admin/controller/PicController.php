<?php
namespace application\admin\controller;
use think\Controller;
use think\Session;
use think\Loader;
use server\fileupload;
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
        $file = request()->file('image');
        //校验器，判断图片格式是否正确
        if (true !== $this->validate(['image' => $file], ['image' => 'require|image'])) {
            $this->error('请选择图像文件');
        } else {
            // 移动到框架应用根目录/public/uploads/ 目录下
            $info = $file->move(ROOT_PATH . 'public' . DS . 'uploads');
            if ($info) {
                // 成功上传后 获取上传信息
				 $data = input();
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
        
    } 
    
}
}