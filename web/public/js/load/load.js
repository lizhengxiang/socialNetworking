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
            if (callback){
                if(result.status == 1){
                    callback(result);
                }else if(result.status == 0){
                    layer.msg('请登录', {
                        offset: 0,
                        shift: 12
                    });
                }else if(result.status == 10){
                    layer.msg('操作失败，非法操作', {
                        offset: 0,
                        shift: 12
                    });
                } 
            }
        },
        error:function (json) {
            layer.msg(json['responseText'], {
                offset: 0,
                shift: 12
            });
        }
    });
};