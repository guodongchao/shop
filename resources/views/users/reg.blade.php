

@extends('layout.bst')


@section('header')
    @parent
    <p style="color: red;">This is Child header.</p>
@endsection

@section('content')

    <form method="post" action="/regadd">
        {{csrf_field()}}
        <div class="form-group">
            <label for="exampleInputEmail1"> 用户名：</label>
                <input type="text" class="form-control" id="exampleInputName" placeholder="name"  name="name">
        </div>
        <div class="form-group">
            <label for="exampleInputPassword1">密码:</label>
            <input type="password" class="form-control" id="exampleInputPassword1" placeholder="pwd"  name="pwd">
        </div>
        <div class="form-group">
            <label for="exampleInputFile">确认密码：</label>
            <input type="password" id="exampleInputFile" class="form-control"  name="password" placeholder="password">
        </div>
        <div class="form-group">
            <label for="exampleInputEmail1"> 邮箱：</label>
            <input type="text" class="form-control" id="exampleInputEmail1" placeholder="Email"  name="email">
        </div>
        <div class="form-group">
            <label for="exampleInputPassword1">年龄:</label>
            <input type="text" class="form-control" id="exampleInputAge" placeholder="age"  name="age">
        </div>

        <button type="submit" class="btn btn-success form-control">添加</button>
    </form>


@endsection


@section('footer')
    @parent
    <p style="color: red;">This is Child footer .</p>
@endsection