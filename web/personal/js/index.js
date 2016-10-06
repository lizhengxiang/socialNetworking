//小提示框
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
                reportNum:'',
                reportNumTag:'',
                praiseTag:'',
                forwardingNumTag:''
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
                                likeNum:resultData[i].praise,
                                reportNum:resultData[i].reportNum,
                                forwardingNum:resultData[i].forwardingNum,
                                reportNumTag:resultData[i].reportNumTag,
                                praiseTag:resultData[i].praiseTag,
                                forwardingNumTag:resultData[i].forwardingNumTag
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
            //res.speakImg,res.speakImg1,res.speakImg2,res.speakImg3,res.nickname,res.school,res.titleTime,res.time,res.content,res.likeNum,res.forwardingNum,res.reportNum，res.reportNumTag,res.praiseTag,res.forwardingNumTag
            personalInformation: function (tag){
                this.information.speakImg = tag.speakImg;
                this.information.speakImg1 = tag.speakImg1;
                this.information.speakImg2 = tag.speakImg2;
                this.information.speakImg3 = tag.speakImg3;
                this.information.nickname = tag.nickname;
                this.information.school = tag.script;
                this.information.titleTime = tag.titleTime;
                this.information.time = tag.time;
                this.information.content = tag.content;
                this.information.likeNum = tag.likeNum;
                this.information.forwardingNum = tag.forwardingNum;
                this.information.reportNum = tag.reportNum;
                this.information.reportNumTag=tag.reportNumTag;
                this.information.praiseTag=tag.praiseTag;
                this.information.forwardingNumTag=tag.forwardingNumTag;
            },
            say: function (msg) {
                alert(msg)
            }
        }
    });

})
