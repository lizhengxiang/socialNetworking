$(function () {
    var data = [
        {
            "id": 0,
            "name": "Item 0",
            "price": "$0"
        },
        {
            "id": 1,
            "name": "Item 1",
            "price": "$1"
        },
        {
            "id": 2,
            "name": "Item 2",
            "price": "$2"
        },
        {
            "id": 3,
            "name": "Item 3",
            "price": "$3"
        },
        {
            "id": 4,
            "name": "Item 4",
            "price": "$4"
        },
        {
            "id": 5,
            "name": "Item 5",
            "price": "$5"
        },
        {
            "id": 6,
            "name": "Item 6",
            "price": "$6"
        },
        {
            "id": 7,
            "name": "Item 7",
            "price": "$7"
        },
        {
            "id": 8,
            "name": "Item 8",
            "price": "$8"
        },
        {
            "id": 9,
            "name": "Item 9",
            "price": "$9"
        },
        {
            "id": 10,
            "name": "Item 10",
            "price": "$10"
        },
        {
            "id": 11,
            "name": "Item 11",
            "price": "$11"
        },
        {
            "id": 12,
            "name": "Item 12",
            "price": "$12"
        },
        {
            "id": 13,
            "name": "Item 13",
            "price": "$13"
        },
        {
            "id": 14,
            "name": "Item 14",
            "price": "$14"
        },
        {
            "id": 15,
            "name": "Item 15",
            "price": "$15"
        },
        {
            "id": 16,
            "name": "Item 16",
            "price": "$16"
        },
        {
            "id": 17,
            "name": "Item 17",
            "price": "$17"
        },
        {
            "id": 18,
            "name": "Item 18",
            "price": "$18"
        },
        {
            "id": 19,
            "name": "Item 19",
            "price": "$19"
        },
        {
            "id": 20,
            "name": "Item 20",
            "price": "$20"
        }
    ];
    $('#table').bootstrapTable('destroy').bootstrapTable({
        data: data,
        dataField: "rows",//服务端返回数据键值 就是说记录放的键值是rows，分页时使用总记录数的键值为total
        height: tableHeight(),//高度调整
        search: true,//是否搜索
        showFooter:true,
        pagination: true,//是否分页
        togglePagination:true,
        pageSize: 10,//单页记录数
        pageList: [5, 10, 20, 50],//分页步进值
        sidePagination: "server",//服务端分页
        contentType: "application/x-www-form-urlencoded",//请求数据内容格式 默认是 application/json 自己根据格式自行服务端处理
        dataType: "json",//期待返回数据类型
        method: "post",//请求方式
        searchAlign: "left",//查询框对齐方式
        queryParamsType: "limit",//查询参数组织方式
        queryParams: function getParams(params) {
            //params obj
            params.other = "otherInfo";
            return params;
        },
        searchOnEnterKey: false,//回车搜索
        showRefresh: true,//刷新按钮
        showColumns: true,//列选择按钮
        buttonsAlign: "left",//按钮对齐方式
        toolbar: "#toolbar",//指定工具栏
        toolbarAlign: "right",//工具栏对齐方式
        columns: [
            {
                title: "全选",
                field: "select",
                checkbox: true,
                width: 20,//宽度
                align: "center",//水平
                valign: "middle"//垂直
            },
            {
                title: "ID",//标题
                field: "id",//键名
                sortable: true,//是否可排序
                order: "desc"//默认排序方式
            },
            {
                field: "name",
                title: "Item Price",
                sortable: true,
                titleTooltip: "this is name"
            },
            {
                field: "info",
                title: "INFO[using-formatter]",
                formatter: 'infoFormatter',//对本列数据做格式化
            }
        ],
        onClickRow: function(row, $element) {
            //$element是当前tr的jquery对象
            $element.css("background-color", "green");
        },//单击row事件
        locale: "zh-CN",//中文支持,
        detailView: false, //是否显示详情折叠
        detailFormatter: function(index, row, element) {
            var html = '';
            $.each(row, function(key, val){
                html += "<p>" + key + ":" + val +  "</p>"
            });
            return html;
        }
    });


    $("#addRecord").click(function(){
        alert("name:" + $("#name").val() + " age:" +$("#age").val());
    });


    function tableHeight() {
        return $(window).height() - 50;
    }
    /**
     * 列的格式化函数 在数据从服务端返回装载前进行处理
     * @param  {[type]} value [description]
     * @param  {[type]} row   [description]
     * @param  {[type]} index [description]
     * @return {[type]}       [description]
     */
    function infoFormatter(value, row, index)
    {
        return "id:" + row.id + " name:" + row.name + " age:" + row.age;
    }
});