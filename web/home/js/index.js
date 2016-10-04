//小提示框
/*;*/

Vue.filter('numeric', {
    read: function(val) {
        return (val / 100).toFixed(2);
    }
});

$(document).ready(function(){
    //绑定数据
    var homedata = new Vue({
        el: '#homedata',
        data: {
            items: [
                
            ],
            information: {
                speakImg:'',
                speakImg1:'',
                speakImg2:'',
                speakImg3:'',
                nickname:'',
                school:'',
                titleTime:'',
                time:'',
                content:'',
                likeNum:'',
                forwardingNum:'',
                reportNum:''
            },
        },
        created: function() {
            this.getData();
        },
        ready: function() {
        },
        methods: {
            getData: function() {
                for(var i=0;i<3;i++){
                this.items.push({
                    speakImg: "https://pbs.twimg.com/media/CtiQsllXEAARtMC.jpg:thumb",
                    speakImg1:"https://pbs.twimg.com/media/CthbTKPWAAAc0T4.jpg",
                    speakImg3: "https://pbs.twimg.com/media/CthYHkzXEAQw7qE.jpg",
                    headImg:"https://pbs.twimg.com/profile_images/768230710163320837/dF5n16wL_bigger.jpg",
                    nickname:"Marvel Entertainment",
                    backgroundImg:"https://pbs.twimg.com/profile_banners/740219796/1471995452/600x200",
                    school:"西南民族大学",
                    signature:"Where the conversation begins. Follow for breaking news, special reports, RTs of our journalists and more from http://NYTimes.com .",
                    dynamic:50,
                    areLookingAt:200,
                    followers:10,
                    time:"120小时前",
                    titleTime:"2013年9月12日 12:56",
                    content:"Lorem ipsum dolor sit amet, consectetur adipisicing elit. Corrupti, illum voluptates consectetur consequatur ducimus. Necessitatibus, nobis consequatur hic eaque laborum laudantium. Adipisci, explicabo, asperiores molestias deleniti unde dolore enim quas.",
                    like:1,
                    forwarding:20,
                    forwardingNum:15
                });
                this.items.push({
                    speakImg: "https://pbs.twimg.com/media/CthYHkzXEAQw7qE.jpg",
                    speakImg1:"https://pbs.twimg.com/media/CthbTKPWAAAc0T4.jpg",
                    speakImg3: "https://pbs.twimg.com/media/CthYHkzXEAQw7qE.jpg",
                    headImg:"https://pbs.twimg.com/profile_images/768230710163320837/dF5n16wL_bigger.jpg",
                    nickname:"Marvel Entertainment",
                    backgroundImg:"https://pbs.twimg.com/profile_banners/740219796/1471995452/600x200",
                    school:"西南",
                    signature:"Where the conversation begins. Follow for breaking news, special reports, RTs of our journalists and more from http://NYTimes.com .",
                    dynamic:50,
                    areLookingAt:200,
                    followers:10,
                    time:"12小时前",
                    titleTime:"2013年9月12日 12:56",
                    content:"Lorem ipsum dolor sit amet, consectetur adipisicing elit. Corrupti, illum voluptates consectetur consequatur ducimus. Necessitatibus, nobis consequatur hic eaque laborum laudantium. Adipisci, explicabo, asperiores molestias deleniti unde dolore enim quas.",
                    like:1,
                    forwarding:20,
                    forwardingNum:15
                });
                }
            },
            personalInformation: function (){
                this.information.speakImg = arguments[0];
                this.information.speakImg1 = arguments[1];
                this.information.speakImg2 = arguments[2];
                this.information.speakImg3 = arguments[3];
                this.information.nickname = arguments[4];
                this.information.school = arguments[5];
                this.information.titleTime = arguments[6];
                this.information.time = arguments[7];
                this.information.content = arguments[8];
                this.information.likeNum = arguments[9];
                this.information.forwardingNum = arguments[10];
                this.information.reportNum = arguments[11];
            },
            say: function (msg) {
                alert(msg)
            }
        }
    });
    //
    $('*').darkTooltip({

    });
    $("[data-toggle='tooltip']").tooltip();

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

