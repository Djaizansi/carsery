function mainWindow(){
    $(".main-wrapper").css({
        width: $('html').width(),
        height: $('html').height() > $(window).height() ? $('html').height() : $(window).height()  
    });
}
function animateWindow(){
    $(".animate-wrp").css({
        width: $(window).width(),
        height: $('.main-wrapper').height()
    });
}
$(document).ready(function() {
    mainWindow();
    animateWindow();
});
$(window).resize(function(event) {
    mainWindow();
    animateWindow();
});