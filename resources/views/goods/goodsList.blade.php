@extends('layout.main')
@section('header')
    @parent
    <p style="color: red;">购物车商品展示</p>
@endsection
@section('content')

    <table class="table table-hover" >
        <tr class="active">
            <td class="success">商品id</td>
            <td class="warning"> 名称</td>
            <td class="success">数量</td>
            <td class="danger">价格</td>
            <td class="info">时间</td>
            <td class="warning">操作</td>
        </tr>
        @foreach ($data as $k=>$v)
            <tr class="active">
                <td class="success">{{$v['goods_id']}}</td>
                <td class="warning">{{$v['goods_name']}}</td>
                <td class="success">{{$v['goods_store']}}</td>
                <td class="danger">{{$v['price']}}</td>
                <td class="info">{{date("Y-m-d H:i:s"),$v['add_time']}}</td>
                <td class="warning">
                    <li class="btn"><a href="/goods/{{$v['goods_id']}}">详情信息</a></li>
                </td>
            </tr>
        @endforeach

    </table>
    {{$data->links()}}
@endsection