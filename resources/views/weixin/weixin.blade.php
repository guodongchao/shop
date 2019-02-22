<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>微信素材添加页面</title>
</head>
<body>
<form action="{{url('/form/test')}}" method="post" enctype="multipart/form-data">
    {{csrf_field()}}
    <h1>微信素材添加页面</h1>
    <table>
        <tr>
            <td><h2>图片上传</h2></td>
            <td><input type="file" name="media"></td>
        </tr>
        <tr>
            <td></td>
            <td><input type="submit" value="添加"></td>
        </tr>
    </table>
</form>
</body>
</html>
