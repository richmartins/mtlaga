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

});
