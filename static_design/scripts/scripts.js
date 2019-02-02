// Handler when the DOM is fully loaded
document.addEventListener("DOMContentLoaded", function(){

    // affichage menu utilisateur
    var arrow = document.getElementById("header_style_menu_actions_arrow");
    var rectangle = document.getElementById("header_style_menu_actions_rectangle");

    arrow.style.display = "none";
    rectangle.style.display = "none";

    document.getElementById("header_style_menu_connexion").onclick = function() {
        if (arrow.style.display === "none") {
            arrow.style.display = "block";
            rectangle.style.display = "block";
        } else {
            arrow.style.display = "none";
            rectangle.style.display = "none";
        }
    };

    // adaptation CSS image header quand scroll
    window.addEventListener( 'scroll', function( event ) {
        var lastScrollTop = 0;
        var element = document.getElementById("header_style_logo");
        var st = window.pageYOffset || document.documentElement.scrollTop;
        if (st > lastScrollTop){
            element.classList.add("header_style_logo_scroll")
        } else {
            element.classList.remove("header_style_logo_scroll")
        }
    }, false );

});
