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

        /**接受微信推送事件*/
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
                    if($id){
                        $arr=WeixinUser::where(['id'=>$id])->first();
                        $openid=$arr['openid'];
                        $access_token=$this->getWXAccessToken();
                        $url='https://api.weixin.qq.com/cgi-bin/message/custom/send?access_token='.$access_token;
                        //请求微信接口
                        $client = new GuzzleHttp\Client(['base_uri' => $url]);
                        $data=[
                            "touser"=>$openid,
                            'msgtype'=>'text',
                            'text'=>[
                                "content"=>"欢迎关注"
                            ]
                        ];
                        $res=$client->request('POST', $url, ['body' => json_encode($data,JSON_UNESCAPED_UNICODE)]);
                        $res_arr=json_decode($res->getBody(),true);

                    }
                }
            } elseif ($event == 'CLICK') {               //click 菜单
                if ($xml->EventKey == 'kefu01') {
                    $this->kefu01($openid, $xml->ToUserName);
                }
            }


        }
        //创建标签
    public function label(){
        //获取获取微信AccessToken
        $access_token=$this->getWXAccessToken();
        //根据id获取openid
        $url="https://api.weixin.qq.com/cgi-bin/tags/members/batchtagging?access_token=$access_token";
        $client = new GuzzleHttp\Client();
        $data=[
            'name'=>"admin",
            'id'=>100
        ];

        $r = $client->request('POST', $url, [
            'body' => json_encode($data)
        ]);
        $response_arr = json_decode($r->getBody(),true);
        // echo '<pre>';print_r($response_arr);echo '</pre>';

        if($response_arr['errcode'] == 0){
            echo "创建标签成功";
        }else{
            echo "创建标签失败";echo '</br>';
            echo $response_arr['errmsg'];
        }
        echo '<pre>';print_r($response_arr);echo '</pre>';
    }
    //标签
    public function labeladd($id){
        //获取获取微信AccessToken
        $access_token=$this->getWXAccessToken();
        //根据id获取openid
        $openid=$this->add($id);
        $url="https://api.weixin.qq.com/cgi-bin/tags/members/batchtagging?access_token=$access_token";
        $client = new GuzzleHttp\Client();
        $data=[
            'openid_list'=>[$openid],
            'tagid' => 2
        ];

        $r = $client->request('POST', $url, [
            'body' => json_encode($data)
        ]);
        $response_arr = json_decode($r->getBody(),true);
       // echo '<pre>';print_r($response_arr);echo '</pre>';

        if($response_arr['errcode'] == 0){
            echo "标签成功";
        }else{
            echo "标签失败";echo '</br>';
            echo $response_arr['errmsg'];
        }
        echo '<pre>';print_r($response_arr);echo '</pre>';
    }
    //黑名单
    public function black($id){
        //获取获取微信AccessToken

        $access_token=$this->getWXAccessToken();

        //根据id获取openid
        $openid=$this->add($id);

        $url="https://api.weixin.qq.com/cgi-bin/tags/members/batchblacklist?access_token=$access_token";
        $client = new GuzzleHttp\Client();
        $data=[
            'openid_list'=>[$openid]
        ];

        $r = $client->request('POST', $url, [
            'body' => json_encode($data)
        ]);
        $response_arr = json_decode($r->getBody(),true);
        //echo '<pre>';print_r($response_arr);echo '</pre>';

        if($response_arr['errcode'] == 0){
            echo "拉入黑名单成功";
        }else{
            echo "拉人黑名单失败";echo '</br>';
            echo $response_arr['errmsg'];
        }
        echo '<pre>';print_r($response_arr);echo '</pre>';

    }
    /**
     * 获取微信AccessToken
     */
    public function getWXAccessToken()
    {
        //获取缓存
        $token = Redis::get($this->redis_weixin_access_token);
        if(!$token){        // 无缓存 请求微信接口
            $url = 'https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid='.env('WEIXIN_APPID').'&secret='.env('WEIXIN_APPSECRET');
            $data = json_decode(file_get_contents($url),true);

            //记录缓存
            $token = $data['access_token'];
            Redis::set($this->redis_weixin_access_token,$token);
            Redis::setTimeout($this->redis_weixin_access_token,3600);
        }
        return $token;

    }

    /**
     * 获取用户信息
     * @param $openid
     */
    public function getUserInfo($openid)
    {
        //$openid = 'oLreB1jAnJFzV_8AGWUZlfuaoQto';
        $access_token = $this->getWXAccessToken();
        $url = 'https://api.weixin.qq.com/cgi-bin/user/info?access_token='.$access_token.'&openid='.$openid.'&lang=zh_CN';
        $data = json_decode(file_get_contents($url),true);
        //echo '<pre>';print_r($data);echo '</pre>';
        return $data;
    }
    /**
    *根据id获取用户id
     */
    public function add($id){
        $arr= WeixinUser::where(['id'=>$id])->first();
        $openid=$arr['openid'];
        return $openid;
    }
}
