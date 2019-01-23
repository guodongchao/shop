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






    public function goods2(Request $request){

        $u_name = $request->input('name');

        if($u_name==''){
            $goods2 = GoodsModel::paginate(3);
        }else{
            $goods2 = GoodsModel::where('goods_name', 'like', "%$u_name%")->paginate(3);
    }
        $list = [
            'data'=>$goods2
        ];
        return view('goods.goodsList',$list);
    }






    public function file(){

        return view('goods.goodsfile');
    }
    public function fileInse(Request $request){
        echo 1;exit;
        $res=$request->file('pdf');
        //var_dump($res);
        $ext  = $res->extension();
        if($ext != 'pdf'){
            die("请上传PDF格式");
        }
        $result = $res->storeAs(date('Ymd'),str_random(5) . '.pdf');
        if($result){
            echo '上传成功';
        }
    }

}