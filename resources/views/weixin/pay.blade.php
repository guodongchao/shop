@extends('layout.main')
@section('content')
    <div id="qrcode"></div>
@endsection
@section('footer')
    @parent
    <script src="{{ asset('/qrcodejs/qrcode.js')}}"></script>
@endsection

