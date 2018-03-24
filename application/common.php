<?php

// 应用公共文件
function p($str) {
    echo '<pre>';
    print_r($str);
}
// 无限极
function nodeTree($arr, $id = 0, $level = 0) {
    static $array = array();
    foreach ($arr as $v) {
        if ($v['parentid'] == $id) {
            $v['level'] = $level;
            $array[] = $v;
            nodeTree($arr, $v['id'], $level + 1);
        }
    }
    return $array;
}

function nodeShu($arr, $id = 0, $level = 0) {
    static $array = array();
    foreach ($arr as $v) {
        if ($v['pid'] == $id) {
            $v['level'] = $level;
            $array[] = $v;
            nodeShu($arr, $v['c_id'], $level + 1);
        }
    }
    return $array;
}


/**
 * 数组转树
 * @param type $list
 * @param type $root
 * @param type $pk
 * @param type $pid
 * @param type $child
 * @return type
 */
function list_to_tree($list, $root = 0, $pk = 'id', $pid = 'parentid', $child = '_child') {
    // 创建Tree
    $tree = array();
    if (is_array($list)) {
        // 创建基于主键的数组引用
        $refer = array();
        foreach ($list as $key => $data) {
            $refer[$data[$pk]] = &$list[$key];
        }
        foreach ($list as $key => $data) {
            // 判断是否存在parent
            $parentId = 0;
            if (isset($data[$pid])) {
                $parentId = $data[$pid];
            }
            if ((string) $root == $parentId) {
                $tree[] = &$list[$key];
            } else {
                if (isset($refer[$parentId])) {
                    $parent = &$refer[$parentId];
                    $parent[$child][] = &$list[$key];
                }
            }
        }
    }
    return $tree;
}

/**
 * 下拉选择框
 */
function select($array = array(), $id = 0, $str = '', $default_option = '') {
    $string = '<select ' . $str . '>';
    $default_selected = (empty($id) && $default_option) ? 'selected' : '';
    if ($default_option)
        $string .= "<option value='' $default_selected>$default_option</option>";
    if (!is_array($array) || count($array) == 0)
        return false;
    $ids = array();
    if (isset($id))
        $ids = explode(',', $id);
    foreach ($array as $key => $value) {
        $selected = in_array($key, $ids) ? 'selected' : '';
        $string .= '<option value="' . $key . '" ' . $selected . '>' . $value . '</option>';
    }
    $string .= '</select>';
    return $string;
}

/**
 * 复选框
 * 
 * @param $array 选项 二维数组
 * @param $id 默认选中值，多个用 '逗号'分割
 * @param $str 属性
 * @param $defaultvalue 是否增加默认值 默认值为 -99
 * @param $width 宽度
 */
function checkbox($array = array(), $id = '', $str = '', $defaultvalue = '', $width = 0, $field = '') {
    $string = '';
    $id = trim($id);
    if ($id != '')
        $id = strpos($id, ',') ? explode(',', $id) : array($id);
    if ($defaultvalue)
        $string .= '<input type="hidden" ' . $str . ' value="-99">';
    $i = 1;
    foreach ($array as $key => $value) {
        $key = trim($key);
        $checked = ($id && in_array($key, $id)) ? 'checked' : '';
        if ($width)
            $string .= '<label class="ib" style="width:' . $width . 'px">';
        $string .= '<input type="checkbox" ' . $str . ' id="' . $field . '_' . $i . '" ' . $checked . ' value="' . $key . '"> ' . $value;
        if ($width)
            $string .= '</label>';
        $i++;
    }
    return $string;
}

/**
 * 单选框
 * 
 * @param $array 选项 二维数组
 * @param $id 默认选中值
 * @param $str 属性
 */
function radio($array = array(), $id = 0, $str = '', $width = 0, $field = '') {
    $string = '';
    foreach ($array as $key => $value) {
        $checked = trim($id) == trim($key) ? 'checked' : '';
        if ($width)
            $string .= '<label class="ib" style="width:' . $width . 'px">';
        $string .= '<input type="radio" ' . $str . ' id="' . $field . '_' . $key . '" ' . $checked . ' value="' . $key . '"> ' . $value;
        if ($width)
            $string .= '</label>';
    }
    return $string;
}

/**
 * 字符串加密、解密函数
 *
 *
 * @param	string	$txt		字符串
 * @param	string	$operation	ENCODE为加密，DECODE为解密，可选参数，默认为ENCODE，
 * @param	string	$key		密钥：数字、字母、下划线
 * @param	string	$expiry		过期时间
 * @return	string
 */
function encry_code($string, $operation = 'ENCODE', $key = '', $expiry = 0) {
    $ckey_length = 4;
    $key = md5($key != '' ? $key : config('encry_key'));
    $keya = md5(substr($key, 0, 16));
    $keyb = md5(substr($key, 16, 16));
    $keyc = $ckey_length ? ($operation == 'DECODE' ? substr($string, 0, $ckey_length) : substr(md5(microtime()), -$ckey_length)) : '';

    $cryptkey = $keya . md5($keya . $keyc);
    $key_length = strlen($cryptkey);

    $string = $operation == 'DECODE' ? base64_decode(strtr(substr($string, $ckey_length), '-_', '+/')) : sprintf('%010d', $expiry ? $expiry + time() : 0) . substr(md5($string . $keyb), 0, 16) . $string;
    $string_length = strlen($string);

    $result = '';
    $box = range(0, 255);

    $rndkey = array();
    for ($i = 0; $i <= 255; $i++) {
        $rndkey[$i] = ord($cryptkey[$i % $key_length]);
    }

    for ($j = $i = 0; $i < 256; $i++) {
        $j = ($j + $box[$i] + $rndkey[$i]) % 256;
        $tmp = $box[$i];
        $box[$i] = $box[$j];
        $box[$j] = $tmp;
    }

    for ($a = $j = $i = 0; $i < $string_length; $i++) {
        $a = ($a + 1) % 256;
        $j = ($j + $box[$a]) % 256;
        $tmp = $box[$a];
        $box[$a] = $box[$j];
        $box[$j] = $tmp;
        $result .= chr(ord($string[$i]) ^ ($box[($box[$a] + $box[$j]) % 256]));
    }

    if ($operation == 'DECODE') {
        if ((substr($result, 0, 10) == 0 || substr($result, 0, 10) - time() > 0) && substr($result, 10, 16) == substr(md5(substr($result, 26) . $keyb), 0, 16)) {
            return substr($result, 26);
        } else {
            return '';
        }
    } else {
        return $keyc . rtrim(strtr(base64_encode($result), '+/', '-_'), '=');
    }
}


/**
 * 功能：邮件发送函数
 * @param string $to 目标邮箱
 * @param string $subject 邮件主题（标题）
 * @param string $to 邮件内容
 * @return bool true
 */
function sendMail($to='974118065@qq.com',$title="hahha",$content="adsasd"){
     
    
     //实例化PHPMailer核心类
     $mail = new \phpmailer\PHPMailer();
     //是否启用smtp的debug进行调试 开发环境建议开启 生产环境注释掉即可 默认关闭debug调试模式
     $mail->SMTPDebug = 1;
     //使用smtp鉴权方式发送邮件
    $mail->isSMTP();
     //smtp需要鉴权 这个必须是true
     $mail->SMTPAuth=true;
     //链接qq域名邮箱的服务器地址
     $mail->Host = 'smtp.qq.com';
     //设置使用ssl加密方式登录鉴权
     $mail->SMTPSecure = 'tls';
     //设置ssl连接smtp服务器的远程服务器端口号，以前的默认是25，但是现在新的好像已经不可用了 可选465或587
     $mail->Port = 587;
     //设置smtp的helo消息头 这个可有可无 内容任意
     $mail->Helo = 'Hello smtp.qq.com Server';
     //设置发件人的主机域 可有可无 默认为localhost 内容任意，建议使用你的域名
     $mail->Hostname = 'localhost';
     //设置发送的邮件的编码 可选GB2312 我喜欢utf-8 据说utf8在某些客户端收信下会乱码
     $mail->CharSet = 'UTF-8';
     //设置发件人姓名（昵称） 任意内容，显示在收件人邮件的发件人邮箱地址前的发件人姓名
     $mail->FromName = '半夏Music';
     //smtp登录的账号 这里填入字符串格式的qq号即可
     $mail->Username ='2211349512';
     //smtp登录的密码 使用生成的授权码 你的最新的授权码
     $mail->Password = 'pazgdrobycqddiac';
     //设置发件人邮箱地址 这里填入上述提到的“发件人邮箱”
     $mail->From = '2211349512@qq.com';
     //邮件正文是否为html编码 注意此处是一个方法 不再是属性 true或false
     $mail->isHTML(true);
     //设置收件人邮箱地址 该方法有两个参数 第一个参数为收件人邮箱地址 第二参数为给该地址设置的昵称 不同的邮箱系统会自动进行处理变动 这里第二个参数的意义不大
    $mail->addAddress($to,'测试通知');
     //添加多个收件人 则多次调用方法即可
     // $mail->addAddress('xxx@qq.com','lsgo在线通知');
     //添加该邮件的主题
     $mail->Subject = $title;
     //添加邮件正文 上方将isHTML设置成了true，则可以是完整的html字符串 如：使用file_get_contents函数读取本地的html文件
    $mail->Body = $content;

    //为该邮件添加附件 该方法也有两个参数 第一个参数为附件存放的目录（相对目录、或绝对目录均可） 第二参数为在邮件附件中该附件的名称
    // $mail->addAttachment('./d.jpg','mm.jpg');
   //同样该方法可以多次调用 上传多个附件
    // $mail->addAttachment('./Jlib-1.1.0.js','Jlib.js');

    $status = $mail->send();

    //简单的判断与提示信息
    if($status) {
        return true;
    }else{
        return false;
     }
 }


 function msubstr($str, $start=0, $length, $charset="utf-8", $suffix=true) {
    if (function_exists("mb_substr")) {
        $slice = mb_substr($str, $start, $length, $charset);
    } elseif (function_exists('iconv_substr')) {
        $slice = iconv_substr($str,$start,$length,$charset);
        if(false === $slice) {
            $slice = '';
        }
    } else {
        $re['utf-8']   = "/[\x01-\x7f]|[\xc2-\xdf][\x80-\xbf]|[\xe0-\xef][\x80-\xbf]{2}|[\xf0-\xff][\x80-\xbf]{3}/";
        $re['gb2312'] = "/[\x01-\x7f]|[\xb0-\xf7][\xa0-\xfe]/";
        $re['gbk']    = "/[\x01-\x7f]|[\x81-\xfe][\x40-\xfe]/";
        $re['big5']   = "/[\x01-\x7f]|[\x81-\xfe]([\x40-\x7e]|\xa1-\xfe])/";
        preg_match_all($re[$charset], $str, $match);
        $slice = join("",array_slice($match[0], $start, $length));
    }
    return $suffix ? $slice.'...' : $slice;
}
 


 //获取时间差;
function beforeTime($time){ 
    $mtime = time()-$time;//获取秒
    $time1 = $mtime/60; //转化为分钟 
    if($time1 < 1 ){
        $time1 = '刚刚';
    }elseif($time1 < 60){
        $time1 = floor($time1).'分钟前';
    }elseif( $time1 >= 60 && $time1 < (60*24) ){
        $time1 = floor($time1/60).'小时前';        
    }elseif ($time1 >= 60*24 && $time1 < (60*24*5)){
        $time1 = floor($time1/60/24).'天前';
    }else{
        $time1 = time_format($time,'m月d日');
    }
    return $time1;
}


/**
 * 时间戳格式化
 * @param int $time
 * @return string 完整的时间显示
 * @author huajie <banhuajie@163.com>
 */
function time_format($time = NULL,$format='Y-m-d H:i'){
    $time = $time === NULL ? time() : intval($time);
    return date($format, $time);
}


/*获取父级曲风分类*/
function get_genre_name($fid){

  $name = db('Cate')->field('c_name')->where('c_id ='.$fid)->find();
  if (!$name) {
       return "顶级";
    }
    foreach ($name as $key => $value) {
       return $value;
   }
}

/*获取曲风分类目录树*/
function get_cate_tree(){
  $genres = S('genre');
  if (empty($genres)){
    $genres = M('Genre')->field(true)->select();
    S('genre',$genres);
  }
  $genres = D('Common/Tree')->toFormatTree($genres,$title = 'name');
  $genres = array_merge(array(0=>array('id'=>"",'title_show'=>'选择曲风')), $genres);
  return  $genres;
}

