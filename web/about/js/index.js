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
    $("#registered").click(function () {
        var registeredArgs =genSearchParams();
        load('site', 'upload', registeredArgs, function(resultData) {
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
    });
})
