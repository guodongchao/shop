@extends('layout.main')

@section('content')
    <h2 align="center">订单支付</h2>
    <input type="hidden" value="{{$code_url}}" id="code">
    <div id="qrcode" align="center"></div>
@endsection
@section('footer')
    @parent
    <script src="{{URL::asset('/js/qrcode.js')}}"></script>
    <script>
        var code=$('#code').val()
        // 设置参数方式
        var qrcode = new QRCode('qrcode', {
            text:code ,
            width: 100,
            height: 100,
            colorDark : '#000000',
            colorLight : '#ffffff',
            correctLevel : QRCode.CorrectLevel.H
        });

        // 使用 API
        qrcode.clear();
        qrcode.makeCode('new content');
    </script>
@endsection
