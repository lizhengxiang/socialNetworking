function load(module, method, params, callback) {
    module = module || 'index';
    method = method || 'index';
    params = params || {};
    callback = callback || false;
    var self = this,
        result = false;
    var url = 'http://socialnetworking.com/index.php?r=';
    var purl =url + module + '/' + method;
     $.ajax({
        type: 'POST',
        url: purl,
        async:true,
        cache: false,
        data: params,
        datatype: 'json',
        success: function(data) {
            alert(data);
        },
    });
};

$("#submit").click( function () {
    load('site', 'hello', {}, function(resultData) {
        alert(resultData);
    });
});

$(document).ready(function() {

   /* var example2 = new Vue({
        el: '#example-2',
        data: {
            parentMessage: 'Parent',
            items: [
                {message: 'Foo'},
                {message: 'Bar'}
            ]
        }
    });*/

    new Vue({
        el: '#app',
        data: {
            todos: [
                {text: 'Learn JavaScript'},
                {text: 'Learn Vue.js'},
                {text: 'Build Something Awesome'}
            ]
        }
    })
})
