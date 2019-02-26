@extends('layout.main')
@section('content')
    <div id="qrcode"></div>
@endsection
@section('footer')
    @parent
    <script src="qrcode.js"></script>
    <script src="{{URL::asset('/qrcodejs/qrcode.js')}}"></script>
@endsection

