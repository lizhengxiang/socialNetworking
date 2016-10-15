//写入Cookie
function setCookie(name, value, seconds) {
    seconds = seconds || 0;   //seconds有值就直接赋值，没有为0，这个根php不一样。
    var expires = "";
    if (seconds != 0 ) {      //设置cookie生存时间
        var date = new Date();
        date.setTime(date.getTime()+(seconds*1000));
        expires = "; expires="+date.toGMTString();
    }
    document.cookie = name+"="+escape(value)+expires+"; path=/";   //转码并赋值
}
//获取Cookie
function getCookie(name)
{
    var arr,reg=new RegExp("(^| )"+name+"=([^;]*)(;|$)");
    if(arr=document.cookie.match(reg))
        return unescape(arr[2]);
    else
        return null;
}

function home() {
    var href = '/home/index.html';
    setCookie('url',href,500000);
    $('iframe').attr('src', href);
}
function personal() {
    var href = '/personal/index.html';
    setCookie('url',href,500000);
    $('iframe').attr('src', href);
}

function mapchat() {
    var href = '/mapchat/index.html';
    setCookie('url',href,500000);
    $('iframe').attr('src', href);
}

function activities() {
    var href = '/activities/index.html';
    setCookie('url',href,500000);
    $('iframe').attr('src', href);
}
$(function () {
    if(getCookie('url') == null){
        var href = '/home/index.html';
        $('iframe').attr('src', href);
    }else {
        var href = getCookie('url');
        $('iframe').attr('src', href);
    }
});
