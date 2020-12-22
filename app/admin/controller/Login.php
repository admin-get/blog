<?php
namespace app\admin\controller;

use think\facade\Db;
use think\facade\View;

class Login extends Entrance
{

    public function Login()
    {
        return View::fetch();
    }

    //登陆验证
    public function dologin(){
        $username = trim(input('post.username'));
        $password = trim(input('post.password'));
        if($username == ''){
            exit(json_encode(array('code'=>1,'msg'=>'用户名不能为空')));
        }
        if($password == ''){
            exit(json_encode(array('code'=>1,'msg'=>'密码不能为空')));
        }
        // 验证用户
        $admin =Db::table('admin')->where('username',$username)->find();
        if(!$admin){
            exit(json_encode(array('code'=>1,'msg'=>'用户不存在')));
        }
        if(md5($admin['username'].$password) != $admin['password']){
            exit(json_encode(array('code'=>1,'msg'=>'密码错误')));
        }
        //判断是否被禁用
        if($admin['state'] == '1'){
            exit(json_encode(array('code'=>1,'msg'=>'用户已被禁用')));
        }
        // 设置用户session
        session('admin',$admin);
        exit(json_encode(array('code'=>0,'msg'=>'登录成功')));
    }
}
