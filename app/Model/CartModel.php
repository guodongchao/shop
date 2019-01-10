<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class CartModel extends Model
{
    //
    public $table = 'cart';
    public $timestamps = false;

    public function CartInfo($goods_id){
        return GoodsModel::where(['goods_id'=>$goods_id])->get();
    }
}
