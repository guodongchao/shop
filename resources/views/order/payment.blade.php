{{-- 购物车 --}}
@extends('layout.main')

@section('content')
    <table class="table table-hover" >
            <tr>
                <td class="active">共{{$arr['order_num']}}件商品</td>
                <td class="success">单价¥{{$arr['order_price']}}</td>
                <td class="warning">共计 ¥{{$arr['order_amount']}}</td>
            </tr>
        <hr>
        <td colspan="5" align="center"> <a href="/alipay/{{$arr['order_id']}}" id="submit_order" class="btn btn-info "> 立即支付 </a></td>

    </table>

@endsection

@section('footer')
    @parent
@endsection