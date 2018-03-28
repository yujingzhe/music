<?php
namespace app\admin\model;
use traits\model\SoftDelete;
use think\Db;
class Cate extends \think\Model {
    use SoftDelete;
    // protected $autoWriteTimestamp;
    protected $autoWriteTimestamp = true;
    //默认自动写入的字段有
    //创建时间和更新时间，他们对应的字段名分别是
    //create_time,和update_time
    //也可以在model里自己设置。
    protected $createTime = 'create_time';
    protected $updateTime = 'update_time';
    protected $deleteTime = 'delete_time';
	public function chaxun() 
	{
		// 查询数据集
		$info = Db::table('bx_cate')
              ->where('bx_cate.delete_time','null')
              // ->select();
              ->paginate(10);
		return $info;
	}

	public function selectCate() {
        $res = db('Cate')
                ->field('c_id,c_name,pid')
                ->where('delete_time','null')
                ->select(); 
        $tmpArr = nodeShu($res);
        $data = array();
        foreach ($tmpArr as $k => $v) {
            $name = $v['level'] == 0 ? '<b>' . $v['c_name'] . '</b>' : '├─' . $v['c_name'];

            $name = str_repeat("│        ", $v['level']) . $name;
            $data[$v['c_id']] = $name;
        }
        // dump($data);
        //exit;
        return $data;
    }
    /**
     *  添加数据集
     * @param [type] $data [description]
     */
    public function add($data) 
    {   
        $data['c_id'] = $data['cid'];
        unset($data['cid']);
        $info = Db::table('bx_cate')->insert($data);
        return $info;
    }


    /**
     * /删除曲风
     * @param  [type] $data [description]
     * @return [type]       [description]
     */
    public function plsc($data) 
    {
        if (is_array($data)) {
            $data = implode(',',$data);           
        }
        $info = Cate::destroy($data);

        
        return $info;
    }


    /**
     * / 查询修改专辑数据
     * @param  [type] $data [description]
     * @return [type]       [description]
     */
    public function xginfo($data) 
    {       
        $info = Db::table('bx_cate')
               ->where('bx_cate.c_id',$data)
               ->field('bx_cate.c_name, bx_cate.pid')
               ->select();
        return $info;
    }
    
    /**
     * / 修改数据集
     * @param  [type] $data [description]
     * @return [type]       [description]
     */
    public function qfxiugai($data) 
    {   
        $data['c_id'] = $data['cid'];
        unset($data['cid']);
        $info = Db::table('bx_cate')->where('c_id',$data['c_id'])->update($data);
        return $info;
    }


	
}