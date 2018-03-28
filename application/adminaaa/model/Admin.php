<?php
namespace app\admin\model;

use think\Db;

class Admin extends \think\Model {

    public $status = array(1 => '无效', 2 => '有效');

    public function getInfo($id) {
        $res = $this->field('id,username,lastloginip,lastlogintime,email,mobile,realname,openid,status')
                ->where(array('id' => $id))
                ->find();
        if ($res) {
            $res = $res->data;
        }

        return $res;
    }

    /**
     * 
     * @param int $userid 用户ID
     * @return Array
     */
    public function getUserGroups($uid) {

        $res = db('admin_group_access')->field('group_id')->where('uid', $uid)->select();

        $userGroups = '';
        if ($res) {
            foreach ($res as $k => $v) {
                $userGroups .= $v['group_id'] . ',';
            }
            return trim($userGroups, ',');
        } else {
            return false;
        }
    }

    /**
     * 登陆更新
     * @param int $type 1:登陆更新,2:信息更新
     * @param int $id id
     * @param array $data 更新的数据
     */
    public function editInfo($type, $id, $data = array()) {
        
        if ($type == 1) {
            $data['lastlogintime'] = time();
            $data['lastloginip'] = ip2long(request()->ip());
        } elseif ($type == 2) {
            $data['updatetime'] = time();
        }
        $res = $this->allowField(true)->save($data, ['id' => $id]);

        return $res;
    }

    public function chaxun($name='',$inf='')
    {
        // 查询管理员是否存在
        $info = Db::name('admin')->where('username',$name)->select();

        if (!$info) {
            return 1; 
        }
        // 判断密码时否正确
        if ($inf == $info[0]['password']) {
            return 3;
        }
        // 判断邮箱时否正确
        if ($inf == $info[0]['email']) {
            return 6;
        }
        return 2;
    }

    public function forget($user,$data)
    {
        $info = Db::name('admin')->where('username',$user)->update($data);
        return $info;
    }

}
