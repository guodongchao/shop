<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>微信素材添加页面</title>
</head>
<body>
<form action="{{url('/weixin/adds')}}" method="post">
    {{csrf_field()}}
    <h1>发送消息给</h1>
    <table>
        <tr>
            <td><h2></h2></td>
            <td><input type="text" name="media"></td>
        </tr>
        <tr>
            <td></td>
            <td><input type="submit" value="发送"></td>
        </tr>
    </table>
</form>
</body>
</html>
