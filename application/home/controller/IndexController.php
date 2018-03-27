<?php
namespace application\home\controller;
use think\Controller;
use think\Session;
use think\Db;
use think\helper\Time;
class IndexController extends Controller{

    public function index() {
        echo '欢迎来到实力至上主义的教室';
    }



}
