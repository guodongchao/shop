<?php

    namespace App\Http\Controllers\Weixin;

    use App\Model\WeixinUser;
    use App\Model\WeixinChatModel;
    use App\Model\WxMedia;
    use Illuminate\Http\Request;
    use App\Http\Controllers\Controller;
    use GuzzleHttp;
    use Illuminate\Support\Facades\Redis;
    use Illuminate\Support\Facades\Storage;

class LaravelController extends Controller
{
    protected $redis_weixin_access_token = 'str:weixin_access_token';     //微信 access_token
    protected $redis_weixin_jsapi_ticket = 'str:weixin_jsapi_ticket';     //微信 access_token
    
    public function wxEvent()
    {
        $data = file_get_contents("php://input");


        //解析XML
        $xml = simplexml_load_string($data);

        $event = $xml->Event;
        $openid = $xml->FromUserName;
        $log_str = date('Y-m-d H:i:s') . "\n" . $data . "\n<<<<<<<";
        file_put_contents('logs/wx_event.log', $log_str, FILE_APPEND);
            if ($event == 'subscribe') {
                $sub_time = $xml->CreateTime;
                echo 'openid: ' . $openid;
                echo '</br>';
                echo '$sub_time: ' . $sub_time;
                //获取用户信息
                $user_info = $this->getUserInfo($openid);
                echo '<pre>';
                print_r($user_info);
                echo '</pre>';

                //保存用户信息
                $u = WeixinUser::where(['openid' => $openid])->first();
                //var_dump($u);die;
                if ($u) {       //用户不存在
                    echo '用户已存在';
                } else {
                    $user_data = [
                        'openid' => $openid,
                        'add_time' => time(),
                        'nickname' => $user_info['nickname'],
                        'sex' => $user_info['sex'],
                        'headimgurl' => $user_info['headimgurl'],
                        'subscribe_time' => $sub_time,
                    ];

                    $id = WeixinUser::insertGetId($user_data);      //保存用户信息
                    var_dump($id);
                }
            } elseif ($event == 'CLICK') {               //click 菜单
                if ($xml->EventKey == 'kefu01') {
                    $this->kefu01($openid, $xml->ToUserName);
                }
            }


        }


}
