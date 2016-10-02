//小提示框
$("[data-toggle='tooltip']").tooltip();
/*;*/

Vue.filter('numeric', {
    read: function(val) {
        return (val / 100).toFixed(2);
    }
});

$(document).ready(function(){
    Vue.config.async = false;
    Vue.config.devtools = false;
    //绑定数据
    var homedata = new Vue({
        el: '#homedata',
        data: {
            res: {
                speakImg: '',
                headImg: 'https://pbs.twimg.com/media/CthYHkzXEAQw7qE.jpg',
                nickname: '',
                backgroundImg:'',
                school: '',
                signature: '',
                dynamic: '',
                areLookingAt:'',
                time:'',
                titleTime:'',
                content:''
            }
        },
        created: function() {
            this.getData();
        },
        ready: function() {
        },
        methods: {
            getData: function() {
                this.res.speakImg= "https://pbs.twimg.com/media/CthYHkzXEAQw7qE.jpg",
                this.res.headImg= "https://pbs.twimg.com/profile_images/768230710163320837/dF5n16wL_bigger.jpg",
                this.res.nickname="Marvel Entertainment",
                this.res.backgroundImg="https://pbs.twimg.com/profile_banners/740219796/1471995452/600x200",
                this.res.school= "西南民族大学",
                this.res.signature= "Where the conversation begins. Follow for breaking news, special reports, RTs of our journalists and more from http://NYTimes.com .",
                this.res.dynamic= 51,
                this.res.areLookingAt=200,
                this.res.time="120小时前",
                this.res.titleTime="2013年9月12日 12:56",
                this.res.content="Lorem ipsum dolor sit amet, consectetur adipisicing elit. Corrupti, illum voluptates consectetur consequatur ducimus. Necessitatibus, nobis consequatur hic eaque laborum laudantium. Adipisci, explicabo, asperiores molestias deleniti unde dolore enim quas."

            }
        }
    });
    //
    $('*').darkTooltip({

    })
    /*homedata.$watch('status', function(val) {
        initDatepicker()
    })
    function initDatepicker() {
        if ($('.datepicker')) {
            $('.datepicker').datepicker({
                language: 'zh-CN',
                autoclose: true,
                format: "yyyy-mm-dd"
            });
        }
    }*/


    //用于处理图片流
    var $container = $('.masonry-container');
    $container.imagesLoaded( function () {
        $container.masonry({
            columnWidth: '.item',
            itemSelector: '.item'
        });
    });
    //Reinitialize masonry inside each panel after the relative tab link is clicked -
    $('a[data-toggle=tab]').each(function () {
        var $this = $(this);
        $this.on('shown.bs.tab', function () {
            $container.imagesLoaded( function () {
                $container.masonry({
                    columnWidth: '.item',
                    itemSelector: '.item'
                });
            });

        }); //end shown
    });  //end each
})

