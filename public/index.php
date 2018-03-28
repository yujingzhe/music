<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2015 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------

// [ 应用入口文件 ]

// 定义应用目录
define('APP_PATH', __DIR__ . '/../application/');

define( "WB_AKEY" , '1604324361' );
define( "WB_SKEY" , '7eb06558b8ca9c1be826653a986e6e1d' );
define( "WB_CALLBACK_URL" , 'http://www.music.com/index/user/callback' );
// 加载框架引导文件
require __DIR__ . '/../thinkphp/start.php';
