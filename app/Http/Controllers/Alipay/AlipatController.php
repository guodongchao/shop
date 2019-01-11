<?php
namespace App\Http\Controllers\Alipay;
use App\Http\Controllers\Controller;
use GuzzleHttp\Client;
class AlipayController extends Controller
{
    public function alipay(){
        $url='http://order_shop.com';
        $client = new Client([
            'base_uri'=>$url,
            'timeout'=>2.0,
        ]);
        $response=$client->request('GET','/index.php');
        echo $response->getBody();

    }
}