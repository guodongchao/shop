<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\UserModel;

class UserController extends Controller
{

    public function abc(Request $request){

        $name=$request->input('u_name');
        $pwd=$request->input('u_pwd');
        $url="http://gdc.hz4155.cn/userlogin";
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, ['u_name' => $name, 'u_pwd' => $pwd]);

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        $response = curl_exec($ch);
        curl_close($ch);
        $response = json_decode($response,true);
        return $response;


    }
    //

	public function user($uid)
	{
		echo $uid;
	}

	public function test()
    {
        echo '<pre>';print_r($_GET);echo '</pre>';
    }

	public function reg(){
	    return view('users.reg');
    }

    public function regadd(Request $request){
	    $reg = request()->all();
       // dump($reg);
       // exit;
        $pwd = $request->input('pwd');
        $password = $request->input('password');
        if($pwd !== $password){
            echo '密码和确认密码不一致';
        }
        $res = password_hash($pwd,PASSWORD_BCRYPT);
       // var_dump($res);
       // exit;
        $data = [
            'name'  => $request->input('name'),
            'email'  => $request->input('email'),
            'age'  => $request->input('age'),
            'reg_time'  => time(),
            'pass' => $res
        ];
        $uid = UserModel::insertGetId($data);
        if($uid){
            setcookie('uid',$uid,time()+86400,'/','gdc.qianqianya.xyz',false,true);
            header("Refresh:2;url=/center");
            echo '添加成功，正在飞过来';
          //  exit;
        }else{
            echo '添加失败';
        }
        /*
        if($uid){
            echo '添加成功';
            //header('refresh:1,/login');
        }else{
        echo '添加失败';
    }*/
    }

    public function login(){
        return view('users.regadd');
    }

    public function loginadd(Request $request ){
        $reg = request()->all();
        //var_dump($reg);
        $pass =  $request->input('pwd');
        $where = [
            'name'=>$reg['name'],
        ];
        $result = UserModel::where($where)->first();
       //dump($result);
      // exit;
        if($result){
          if(password_verify($pass,$result->pass)){
              $token = substr(md5(time().mt_rand(1,99999)),10,10);
              setcookie('uid',$result->uid,time()+86400,'/','gdc.qianqianya.xyz',false,true);
              setcookie('token',$token,time()+86400,'/login','',false,true);
              $request->session()->put('u_token',$token);
              $request->session()->put('uid',$result->uid);
              header("Refresh:3;url=/center");



                echo '登陆成功';
          }else{
              echo '登录失败';
          }
        }else{
            echo '用户名不存在';
        }

    }

    public function center(){
        if(empty($_COOKIE['uid'])){
            header('Refresh:2;url=/login');
            echo '请先登录';
            exit;
        }else{
            echo 'UID: '.$_COOKIE['uid'] . ' 欢迎回来';
        }
    }
}
