<?php

/**
 * 后台公共文件 
 */

namespace application\admin\controller;

use think\Controller;

class CommonController extends Controller {

    protected $a_id;
    protected $a_name;

    public function __construct(\think\Request $request = null) {

        parent::__construct($request);

        if (!session('a_id')) {

            // $this->error('请登陆', 'login/index', '', 0);
           echo "<script>alert('你还没有登录')</script>"; 
           // echo "<script>window.location.href='login/index';</script>";
           $this->redirect('Login/index');
           exit();
        }

        $this->a_id = session('a_id');
        $this->a_name = session('a_name');

        //权限检查
        if (!$this->_checkAuthor($this->a_id)) {
            // $this->error('你无权限操作');
             echo "<script>alert('你无权限操作')</script>"; 
            echo "<script>window.history.go(-1)</script>";
            exit();
        }

        //记录日志
        $this->_addLog();
    }

    /**
     * 权限检查
     */
    private function _checkAuthor($a_id) {
        
        if (!$a_id) {
            return false;
        }
        if($a_id==1){
            return true;
        }
        $c = strtolower(request()->controller());
        $a = strtolower(request()->action());

        if (preg_match('/^public_/', $a)) {
            return true;
        }
        if ($c == 'index' && $a == 'index') {
            return true;
        }
        $menu = model('Menu')->getMyMenu($a_id);
        foreach ($menu as $k => $v) {
            if (strtolower($v['c']) == $c && strtolower($v['a']) == $a) {
                return true;
            }
        }
        return false;
    }

    /**
     * 记录日志
     */
    private function _addLog() {

        $data = array();
        $data['querystring'] = request()->query()?'?'.request()->query():'';
        $data['m'] = request()->module();
        $data['c'] = request()->controller();
        $data['a'] = request()->action();
        $data['userid'] = $this->a_id;
        $data['username'] = $this->a_name;
        $data['ip'] = ip2long(request()->ip());
        $arr = array('Index/index','Log/index','Menu/index');
        if (!in_array($data['c'].'/'.$data['a'], $arr)) {
            db('admin_log')->insert($data);
        } 
    }

}
