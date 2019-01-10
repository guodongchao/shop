@extends('layout.main')
@section('header')
    @parent
    <p style="color: red;">购物车商品展示</p>
@endsection
@section('content')

    <table class="table table-hover" >
        <tr class="active">
            <td class="success">订单id</td>
            <td class="warning"> 订单号</td>
            <td class="success">价格</td>
            <td class="danger">时间</td>
            <td class="warning">操作</td>
        </tr>
        @foreach ($arr as $k=>$v)
            <tr class="active">
                <td class="success">{{$v['order_id']}}</td>
                <td class="warning">{{$v['order_sn']}}</td>
                <td class="success">{{$v['order_amount']}}</td>
                <td class="danger">{{$v['add_time']}}</td>
                <td class="warning">
                    <li class="btn">
                        @if($v['state']==1)
                        <a href="/order/payments/{{$v['order_id']}}/{{$type=1}}">付款</a>
                        @elseif($v['state']==2)
                        已付款 <a href="/order/payments/{{$v['order_id']}}/{{$type=2}}">退款</a>
                        @endif
                    </li>

                </td>
            </tr>
        @endforeach

    </table>
@endsection