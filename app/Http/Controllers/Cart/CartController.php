<?php

namespace App\Http\Controllers\Cart;

use App\Model\GoodsModel;
use App\Model\CartModel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CartController extends Controller
{

    public function __construct()
    {
/*
        $this->middleware(function($request,$next){
            //验证是否有登录token
            if(!session()->exists('token')){
                header('Refresh:2;url=/login');
                echo '请先登录';
                exit();
            }
            return $next($request);
        });
*/
        $this->middleware(function ($request, $next) {
            $this->uid = session()->get('uid');
            return $next($request);
        });
    }

    public function index(Request $request)
    {
/*
        $goods = session()->get('cart_goods');
     //   var_dump($goods);exit;
        if(empty($goods)){
            echo '购物车是空的';
        }else{
            foreach($goods as $k=>$v){
                echo 'Goods ID: '.$v;echo '</br>';
                $detail = GoodsModel::where(['goods_id'=>$v])->first()->toArray();
                echo '<pre>';print_r($detail);echo '</pre>';
            }
        }
*/
        $cart_goods = CartModel::where(['uid'=>$this->uid])->get()->toArray();
        if(empty($cart_goods)){
            die("购物车是空的");
        }

        //echo '<pre>';print_r($cart_goods);echo '</pre>';echo '<hr>';
        if($cart_goods){
            //获取商品最新信息
            foreach($cart_goods as $k=>$v){
                $goods_info = GoodsModel::where(['goods_id'=>$v['goods_id']])->first();
                $goods_info['num']  = $v['num'];
                $goods_info['cart_id']=$v['cart_id'];
                //echo '<pre>';print_r($goods_info);echo '</pre>';
                $list[] = $goods_info;
            }
        }
        $data = [
            'list'  => $list
        ];
        return view('cart.cart',$data);


    }

    /**
     * 添加商品
     */

    public function add($goods_id){
        $goods = session()->get('cart_goods');
        //商品是否已存在
        if(!empty($cart_goods)){
            if(in_array($cart_goods,$goods_id)){
                echo '该商品已存在';
                exit;
            }
           // var_dump($goods_id);
       //     exit;
        }

        //减库存
        session()->push('cart_goods',$goods_id);
        $where = [
            'goods_id'=>$goods_id
        ];
        $res = GoodsModel::where($where)->value('goods_store');
        if($res<=0){
            echo '商品库存不足';
            exit;
        }
        $result = GoodsModel::where($where)->decrement('goods_store');
        if($result){
                echo '添加成功';
        }
    }
/*
    public function  del($goods_id){
        $goods = session()->get('cart_goods');
        if(in_array($goods_id,$goods)){
                //删除
            foreach($goods as $k=>$v){
                if($goods_id == $v){
                    session()->pull('cart_goods.'.$k);
                }
            }
            }else{
                exit('商品不在购物车中');
        }
    }
*/

    /**
     * 添加到购物车
     */
    public function add2(Request $request){
            $goods = $request->input('goods_id');
            $num = $request->input('num');
            //var_dump($num);exit;
            $where = [
                'goods_id'=>$goods,
            ];

            //检查库存
            $res = GoodsModel::where($where)->value('goods_store');
            //var_dump($res);exit;
            if($res<$num){
                $response = [
                    'errno'=>5001,
                    'msg'=>'库存不足',
                ];
                return $response;
            }


            //购物车添加
            $data = [
                'goods_id'=>$goods,
                'num'=>$num,
                'add_time'=>time(),
                'uid'=>session()->get('uid'),
                'session_token'=>session()->get('u_token'),
            ];
          //  var_dump($data);exit;
        $cid = CartModel::insertGetId($data);
        if(!$cid){
            $response = [
                'errno' => 5001,
                'msg'   => '添加购物车失败，请重试'
            ];
            return $response;
        }
        $response = [
            'error' => 0,
            'msg'   => '添加成功'

        ];

        $result = GoodsModel::where($where)->decrement('goods_store',$num);

        return $response;
    }


    /**
     * 删除商品
     */
    public function del($goods_id)
    {
        //判断 商品是否在 购物车中
        $goods = session()->get('cart_goods');
        // echo '<pre>';print_r($goods);echo '</pre>';die;

        if(in_array($goods_id,$goods)){
            //执行删除
            foreach($goods as $k=>$v){
                if($goods_id == $v){
                    session()->pull('cart_goods.'.$k);
                }
            }
        }else{
            //不在购物车中
            die("商品不在购物车中");
        }

    }

    public function del2($cart_id){
       // $res = session()->get('uid');
        $where = [
            'cart_id'=>$cart_id,
            'uid'=>$this->uid,
        ];
        $result = CartModel::where($where)->delete();
        if($result){
            echo '商品ID:  '.$cart_id . ' 删除成功1';
            header("Refresh:1;url=/cart");
        }else{
            echo '商品ID:  '.$cart_id . ' 删除成功2';
            header("Refresh:1;url=/cart");
        }
    }
}

