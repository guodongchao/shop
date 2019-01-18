<?php

namespace App\Http\Controllers\Goods;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Model\GoodsModel;

class GoodsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * 商品详情
     * @param $goods_id
     */
    public function goods($goods_id)
    {
        $goods = GoodsModel::where(['goods_id'=>$goods_id])->first();

        //商品不存在
        if(!$goods){
            header('Refresh:2;url=/');
            echo '商品不存在,正在跳转至首页';
            exit;
        }

        $data = [
            'goods' => $goods
        ];
        return view('goods.goods',$data);
    }

    public function goods2(){
        $goods2 = GoodsModel::paginate(2);
        $list = [
            'data'=>$goods2
        ];
        return view('goods.goodsList',$list);
    }
}