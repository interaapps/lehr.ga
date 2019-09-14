function setCookie(cookieName,cookieValue,daysToExpire) {
    var date = new Date();
    date.setTime(date.getTime()+(daysToExpire*24*60*60*1000));
    document.cookie = cookieName + "=" + cookieValue + "; path=/; expires=" + date.toGMTString();
    
}

function getCookie(cookieName) {
    var name = cookieName + "=";
    var allCookieArray = document.cookie.split(';');
    for(var i=0; i<allCookieArray.length; i++) {
        var temp = allCookieArray[i].trim();
        if (temp.indexOf(name)==0)
        return temp.substring(name.length,temp.length);
    }
    return "";
}

function changeDarkMode() {
    if ($("#darkmode").attr("href") == "/assets/css/darkmode.css") {
        $("#darkmode").attr("href", "/assets/css/empty.css");
        setCookie("darkmode", "false", 230);
    } else {
        $("#darkmode").attr("href", "/assets/css/darkmode.css");
        setCookie("darkmode", "true", 230);
    }    
}

$(document).ready(function () {
    Waves.attach(".rippleeffect");
    Waves.init();
});