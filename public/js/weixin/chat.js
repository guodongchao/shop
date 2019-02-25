var openid = $("#openid").val();

setInterval(function(){
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url     :   '/weixin/chat/get_msg?openid=' + openid + '&pos=' + $("#msg_pos").val(),
        type    :   'get',
        dataType:   'json',
        success :   function(d){
            if(d.errno==0){     //服务器响应正常
                //数据填充
                var msg_str = '<blockquote>' + d.data.created_at +
                    '<p>' + d.data.msg + '</p>' +
                    '</blockquote>';

                $("#chat_div").append(msg_str);
                $("#msg_pos").val(d.data.id)
            }else{

            }
        }
    });
},5000);

// 客服发送消息 begin
$("#send_msg_btn").click(function(e){
    e.preventDefault();
    var send_msg = $("#send_msg").val().trim();
    var openid = $("#openid").val().trim();
    
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url     :   '/weixin/chat/get_msgs?send_msg=' + send_msg + '&openid=' + openid,
        type    :   'get',
        dataType:   'json',
        success :   function(d){
            if(d.errno==0){     //服务器响应正常
                //数据填充
                var msg_str = '<blockquote>' + d.data.created_at +
                    '<p>' + d.data.msg + '</p>' +
                    '</blockquote>';

                $("#chat_div").append(msg_str);
                $("#msg_pos").val(d.data.id)
            }else{

            }
        }
    });
});
// 客服发送消息 end
