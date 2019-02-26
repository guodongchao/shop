@extends('layout.main')
@section('content')
    <div id="qrcode"></div>
@endsection
@section('footer')
    @parent
    <script src="qrcode.js"></script>
    <script src="{{URL::asset('/qrcodejs/qrcode.js')}}"></script>
@endsection

<script>
    // 简单方式
    new QRCode(document.getElementById('qrcode'), 'your content');

    // 设置参数方式
    var qrcode = new QRCode('qrcode', {
        text: 'your content',
        width: 256,
        height: 256,
        colorDark : '#000000',
        colorLight : '#ffffff',
        correctLevel : QRCode.CorrectLevel.H
    });

    // 使用 API
    qrcode.clear();
    qrcode.makeCode('new content');
</script>
