<?php

namespace application\admin\controller;

class LogController extends CommonController {

    public function index() {
        $where = array();
        $lists = db("admin_log")->where($where)->order('id desc')->paginate(10);
        $this->assign('lists', $lists);
        return $this->fetch();
    }

}
