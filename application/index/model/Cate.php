<?php

namespace app\index\model;
use think\Db;
use think\Model;
use traits\model\SoftDelete;

class Cate extends Model
{
	
    public function catetree(){
        $data = Db::name('cate')->where('delete_time','null')->select();
        //dump($data);die;
        return $this->sort($data);
    }

    public function sort($data,$pid=0,$level=0){
        static $arr=array();
        foreach ($data as $k => $v) {
            if($v['pid']==$pid){
                $v['level']=$level;
                $arr[]=$v;
              
                $this->sort($data,$v['c_id'],$level+1);
            }
        }
        return $arr;
    }
	
  
}