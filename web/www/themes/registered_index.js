function load(module, method, params, callback) {
    module = module || 'index';
    method = method || 'index';
    params = params || {};
    callback = callback || false;
    var self = this,
        result = false;
    var url = 'http://socialnetworking.com/index.php?r=';
    var purl =url + module + '/' + method;
    var result = false;
    $.ajax({
        type: 'POST',
        url: purl,
        async:true,
        cache: false,
        data: params,
        datatype: 'json',
        success: function(json) {
            if (typeof json === 'string') {
                result = eval('(' + json + ')');
            } else {
                result = json;
            }
            if (callback)
                callback(result);
        },
        error:function (json) {
            layer.msg(json['responseText'], {
                offset: 0,
                shift: 12
            });
        }
    });
};

function genSearchParams()
{
    var searchParams = $("#frmSearch").serializeArray();
    return searchParams;
}

$(document).ready(function() {
    load('registered', 'provinces', {}, function(resultData) {
        var temp = '';
        for(var i =0; i<resultData.length; i++){
            temp += '<option value ='+resultData[i].id+'>'+resultData[i].name+'</option>';
        }
        $("#provinces").append(temp);
    });
    $("#provinces").change( function() {
        var provinces = $('#provinces option:selected').val();
        load('registered', 'getschool', {'parentid':provinces}, function(resultData) {
            var temp = '';
            for(var i =0; i<resultData.length; i++){
                temp += '<option value ='+resultData[i].id+'>'+resultData[i].name+'</option>';
            }
            $("#school").empty();
            $("#school").append(temp);
        });
    });
    var year = '',mouth='',day='';
    for(var i = 1980; i< 2016; i++){
        year += '<option value ='+i+'>'+i+'</option>';
    }
    $("#year").append(year);
    for(var i = 1; i< 13; i++){
        mouth += '<option value ='+i+'>'+i+'</option>';
    }
    $("#mouth").append(mouth);
    for(var i = 1; i< 32; i++){
        day += '<option value ='+i+'>'+i+'</option>';
    }
    $("#day").append(day);
    $("#registered").click(function () {
        var tag = 0;
        var registeredArgs =genSearchParams();
        if(isNaN(registeredArgs[0].value)){
            layer.tips('请选择省份', '#provinces', {
                tips: [4, '#78BA32'],
                tipsMore: true
            });
            tag = 1;
        }
        if(isNaN(registeredArgs[1].value)){
            layer.tips('请选择学校', '#school', {
                tips: [4, '#78BA32'],
                tipsMore: true
            });
            tag = 1;
        }
        var reg = /(^[a-zA-Z0-9_-]+@[a-zA-Z0-9_-]+\.[a-zA-Z0-9_-]+$)|(^$)/;
        if(registeredArgs[2].value.length == 0 || !reg.test(registeredArgs[2].value)){
            layer.tips('请填写正确的邮箱（xx@xx.com）', '#inputEmail', {
                tips: [4, '#78BA32'],
                tipsMore: true
            });
            tag = 1;
        }
        if(registeredArgs[3].value.length < 1 || registeredArgs[3].value.length > 10 ){
            layer.tips('昵称字数个数（1-10)', '#nickname', {
                tips: [4, '#78BA32'],
                tipsMore: true
            });
            tag = 1;
        }
        if(!tag){
            load('registered', 'registered', registeredArgs, function(resultData) {
                if(resultData == 1){
                    layer.msg('注册成功', {
                        offset: 0,
                        shift: 12
                    });
                }else {
                    layer.msg('注册失败', {
                        offset: 0,
                        shift: 12
                    });
                }
            });
        }

        //演示代码
        layui.use('layim', function(layim){
            var layim = layui.layim;
            layim.config({
                //配置客户信息
                mine: {
                    "username": "访客" //我的昵称
                    ,"id": "100000123" //我的ID
                    ,"status": "online" //在线状态 online：在线、hide：隐身
                    ,"remark": "在深邃的编码世界，做一枚轻盈的纸飞机" //我的签名
                    ,"avatar": "http://res.layui.com/images/fly/avatar/00.jpg" //我的头像
                }
                //开启客服模式
                ,brief: true
            });
            //打开一个客服面板
            layim.chat({
                name: '在线客服一' //名称
                ,type: 'kefu' //聊天类型
                ,avatar: 'http://tp1.sinaimg.cn/5619439268/180/40030060651/1' //头像
                ,id: 1111111 //定义唯一的id方便你处理信息
            }).chat({
                name: '在线客服二' //名称
                ,type: 'kefu' //聊天类型
                ,avatar: 'http://tp1.sinaimg.cn/5619439268/180/40030060651/1' //头像
                ,id: 2222222 //定义唯一的id方便你处理信息
            });
            layim.setChatMin(); //收缩聊天面板
        });

        
    });
})
