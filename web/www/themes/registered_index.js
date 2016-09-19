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
    for(var i = 1880; i< 2016; i++){
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
        var registeredArgs = genSearchParams();
        load('registered', 'registered', registeredArgs, function(resultData) {
            var temp = '';
            for(var i =0; i<resultData.length; i++){
                temp += '<option value ='+resultData[i].id+'>'+resultData[i].name+'</option>';
            }
            $("#provinces").append(temp);
        });
        
    });
})
