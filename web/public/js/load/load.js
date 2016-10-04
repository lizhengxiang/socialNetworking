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
                callback(result);
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