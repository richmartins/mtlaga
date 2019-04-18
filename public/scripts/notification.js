/**
 * Notif user with popup
 * @param type
 * @param message
 */
function notif (type, message) {
    $("#header_notif_load").css('display', 'none');

    var responsediv = "#header_notif_" + type
    $(responsediv).css('display', 'flex');
    $(responsediv).addClass("fadeInDown")
    $(responsediv).children().next().text(message)
    setTimeout(function(){
        $(responsediv).addClass("fadeOutUp")
    }, 1500)
    $(responsediv).removeClass("fadeOutUp")
}