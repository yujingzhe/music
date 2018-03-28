<?php

namespace app\admin\controller;

class GroupController extends CommonController {

    public function index() {
        $res = db('admin_group')->select();
        $this->assign('lists', $res);
        return $this->fetch();
    }

    /*
     * 查看
     */

    public function info() {
        $id = input('id');
        if ($id) {
            //当前用户信息
            $info = db('admin_group')->find($id);
            $this->assign('info', $info);
        }

        return $this->fetch();
    }

    /*
     * 添加
     */

    public function add() {
        $data = input();
        $res = model('Admin_group')->allowField(true)->save($data);
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
        $res = model('Admin_group')->allowField(true)->save($data, ['id' => $data['id']]);
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
        $res = db('admin_group')->where(['id' => $id])->delete();
        if ($res) {
            db('admin_group_access')->where(['group_id'=>$id])->delete();
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
     * 权限
     */
    public function rule() {

        //echo APP_PATH;exit;
        if (input('gid')) {
            $gid = input('gid');
            $rules = db('admin_group')->where('id',$gid)->value('rules');
            $this->assign('rules',$rules);
            
            $menu = db('menu')->order('listorder asc')->select();
            $this->assign('menu', list_to_tree($menu));
            return $this->fetch();
        }
    }

    public function editRule() {
        $post = input();
        if ($post['id']) {
            $where = ['id' => $post['id']];

            $rules = implode(',', $post['rules']);
            $data = array();
            $data['updatetime'] = time();
            $data['rules'] = $rules;

            $res = model('admin_group')->save($data, $where);

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
    }

}
