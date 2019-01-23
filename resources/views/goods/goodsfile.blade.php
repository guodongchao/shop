@extends('layout.main')
@section('content')
    <div class="container">
        <form class="form-inline" action="/update/inse" method="post" enctype="multipart/form-data">
                    <input type="file" class="form-control" name="file" >
                    <input type="submit" value="上传">
        </form>
    </div>
@endsection

@section('footer')
    @parent

@endsection