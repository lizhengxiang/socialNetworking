var $table = $('#table'), $remove = $('#remove'), selections = [];

//获取url中的参数
function getUrlParam(name) {
    var reg = new RegExp("(^|&)" + name + "=([^&]*)(&|$)"); //构造一个含有目标参数的正则表达式对象
    var r = window.location.search.substr(1).match(reg); //匹配目标参数
    if (r != null) return unescape(r[2]); return null; //返回参数值
}
var id= getUrlParam('id');
$(function () {
    function operateFormatter(value, row, index) {
        return [
            '<a class="like" href="javascript:void(0)" title="Like">',
            '详情',
            '</a>',
        ].join('');
    }

    window.operateEvents = {
        'click .like': function (e, value, row, index) {
            window.location.href="/activities/details.html?id="+row.id;
        }
    };

    function initTable() {
        $table.bootstrapTable({
            url:"/index.php?r=activities/getdetails&id="+id,
            height: getHeight(),
            columns: [
                {
                    field: 'activitiesname',
                    title: '名称',
                    align: 'center'
                },
                {
                    field: 'authorization',
                    title: '授权码',
                    align: 'center'
                },
                {
                    field: 'createtime',
                    title: '创建时间',
                    align: 'center',
                },
                {
                    field: 'operate',
                    title: '操作',
                    align: 'center',
                    events: operateEvents,
                    formatter: operateFormatter
                }
            ],
        });
        // sometimes footer render error.
        setTimeout(function () {
            $table.bootstrapTable('resetView');
        }, 200);
    }

    function getHeight() {
        return $(window).height() - $('h1').outerHeight(true)-100;
    }

    var scripts = [
             '/public/js/bootstraptable/js/bootstrap-table.js',
        ],
        eachSeries = function (arr, iterator, callback) {
            callback = callback || function () {};
            if (!arr.length) {
                return callback();
            }
            var completed = 0;
            var iterate = function () {
                iterator(arr[completed], function (err) {
                    if (err) {
                        callback(err);
                        callback = function () {};
                    }
                    else {
                        completed += 1;
                        if (completed >= arr.length) {
                            callback(null);
                        }
                        else {
                            iterate();
                        }
                    }
                });
            };
            iterate();
        };
    eachSeries(scripts, getScript, initTable);
});

function getScript(url, callback) {
    var head = document.getElementsByTagName('head')[0];
    var script = document.createElement('script');
    script.src = url;
    var done = false;
    // Attach handlers for all browsers
    script.onload = script.onreadystatechange = function() {
        if (!done && (!this.readyState ||
            this.readyState == 'loaded' || this.readyState == 'complete')) {
            done = true;
            if (callback)
                callback();

            // Handle memory leak in IE
            script.onload = script.onreadystatechange = null;
        }
    };
    head.appendChild(script);
    return undefined;
}