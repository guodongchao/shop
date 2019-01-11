<?php

namespace App\Http\Controllers\Order;

use App\Model\CartModel;
use App\Model\GoodsModel;
use DemeterChain\C;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Model\OrderModel;

class OrderController extends Controller
{
    /**提交订单*/
    public function add(Request $request){
        $where = [
            'uid'=>session()->get('uid'),
        ];
        $res = CartModel::where($where)->orderBy('cart_id','desc')->get()->toArray();
        if(empty($res)){
            echo '购物车中没有商品';
        }
        $order_amount = 0;
        foreach ($res as $k=>$v){
            $where = [
                'goods_id'=>$v['goods_id'],
            ];
            $goods_info = GoodsModel::where($where)->first()->toArray();
            $goods_info['num'] = $v['num'];
            $list[] = $goods_info['num'];

            //计算订单价格 = 商品数量 * 单价
            $order_amount += $goods_info['price'] * $v['num'];

        }
        //生成订单号
        $order_sn = OrderModel::generateOrderSN();
        echo $order_sn;
        $data = [
            'uid'=>session()->get('uid'),
            'order_sn'=>$order_sn,
            'order_amount'=>$order_amount,
            'add_time'=>time(),
            'order_price'=>$goods_info['price'],
            'order_num'=>$v['num']
        ];
        $info = OrderModel::insertGetId($data);
        if(!$info){
            echo '生成订单失败';
        }
        echo '下单成功,订单号：'.$info .'跳转支付';
        //清空购物车
        CartModel::where(['uid'=>session()->get('uid')])->delete();
        header('Refresh:2,/order/list');
    }

    /**展示订单*/
    public function list(){
        $arr=OrderModel::all();
        $data=[
            'arr'=>$arr
        ];
        return view('order.list',$data);
    }

    public  function payment($order_id){

        $where=[
            'order_id'=>$order_id,
        ];
        $arr=OrderModel::where($where)->first()->toArray();
        $data=[
            'arr'=>$arr
        ];
        return view('order.payment',$data);
    }
    public  function payments($order_id,$type){

        if($type==1){
            $wheres=[
                'state'=>2
            ];
            $test='支付成功';
        }else{
            $wheres=[
                'state'=>1
            ];
            $test='退款成功';
        }
        $where=[
            'order_id'=>$order_id,
        ];
        $arr=OrderModel::where($where)->update($wheres);
        if($arr){
            echo $test;
            header('refresh:2,/order/list');
        }else{
            echo '操作00失败';
            header('refresh:2,/order/list');
        }
    }

}