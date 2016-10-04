//小提示框
/*;*/




$(document).ready(function(){
    //绑定数据
    Vue.config.async = false;
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
        },
        ready: function() {
            this.getData();
        },
        methods: {
            getData: function() {
                var self = this;
                load('personal', 'dynamic', {}, function(resultData) {
                    var len = resultData.length;
                    if(len >= 1){
                        for(var i=0;i<len;i++){
                            self.items.push({
                                speakImg: resultData[i].pic1,
                                speakImg1:resultData[i].pic2,
                                speakImg3: resultData[i].pic4,
                                headImg:resultData[i].headPortrait,
                                nickname:resultData[i].nickname,
                                backgroundImg:resultData[i].backgroundImage,
                                school:resultData[i].school,
                                signature:resultData[i].motto,
                                dynamic:50,
                                areLookingAt:200,
                                followers:10,
                                time:resultData[i].time,
                                titleTime:resultData[i].createtime,
                                content:resultData[i].content,
                                like:resultData[i].praise,
                                forwarding:resultData[i].forwarding,
                                forwardingNum:resultData[i].forwardingNum
                            });
                        }
                        $('*').darkTooltip({

                        });
                        $("[data-toggle='tooltip']").tooltip();
                    }else {
                        layer.msg('获取数据失败', {
                            offset: 0,
                            shift: 12
                        });
                    }
                });
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

})
