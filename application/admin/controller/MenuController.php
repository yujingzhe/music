<?php
namespace application\admin\controller;

use think\Loader;

class MenuController extends CommonController {

    public function index() {
        $res = db('menu')->order('listorder asc')->select();
        $lists = nodeTree($res);
        $this->assign('lists', $lists);
        return $this->fetch();
    }

    /*
     * 查看
     */

    public function info() {


        $id = input('id');
        if ($id) {
            //当前用户信息
            $info = db('menu')->find($id);
            $this->assign('info', $info);
        }


        //下拉菜单
        $this->assign('selectMenu', Loader::model('Menu')->selectMenu());
        return $this->fetch();
    }

    /*
     * 添加
     */

    public function add() {
        $data = input();
        if ($data['parentid'] == null) {
            $data['parentid'] = 0;
        }
        $res = model('menu')->allowField(true)->save($data);
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
     * 修改
     */

    public function edit() {

        $data = input();
        $data['updatetime'] = time();
        if ($data['parentid'] == null) {
            $data['parentid'] = 0;
        }

        $res = model('menu')->allowField(true)->save($data, ['id' => $data['id']]);
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
     * 删除
     */

    public function del() {
        $id = input('id');
        $res = db('menu')->where(['id' => $id])->delete();
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
     * 排序
     */
    public function setListorder() {

        if ($_POST['listorder']) {
            $listorder = $_POST['listorder'];
            foreach ($listorder as $k => $v) {
                $data = array();
                $data['listorder'] = $v;
                $data['updatetime'] = time();
                $res = db('menu')->where(['id' => $k])->update($data);
            }
            if ($res) {
                 echo "<script>alert('排序成功')</script>"; 
           echo "<script>window.location.href='index';</script>";
           exit();
           
        } else {
         
            echo "<script>alert('排序失败')</script>"; 
            echo "<script>window.history.go(-1)</script>";
            exit();
            }
        }
    }

}
