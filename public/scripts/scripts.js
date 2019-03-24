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

    /*
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
    */
});

$( document ).ready(function() {

    // itinéraire show more
    var acc = document.getElementsByClassName("itineraire_flex_container_travel_accordion");
    var i;

    for (i = 0; i < acc.length; i++) {
        acc[i].onclick = function(){
            this.closest('.itineraire_flex_container_travel_bck').classList.toggle("active");
            this.closest('.itineraire_flex_container_travel_bck').nextElementSibling.classList.toggle("show");
            //this.classList.toggle("active");
            //this.nextElementSibling.classList.toggle("show");
        };
    }
    $(".itineraire_flex_container_travel_rotate").click(function(){
        $(this).toggleClass("down");
    });

    $(".itineraire_flex_container_travel_action_outils_icon").mouseover(function() {
        $(this).children(":nth-child(2)").hide()
        $(this).children(":nth-child(3)").show()
    });
    $(".itineraire_flex_container_travel_action_outils_icon").mouseleave(function() {
        $(this).children(":nth-child(2)").show()
        $(this).children(":nth-child(3)").hide()
    });

    // init flartpickr sur classe flatpickr_selector
    flatpickr(".flatpickr_selector", {
        enableTime: true,
        dateFormat: "d.m.Y | H:i",
        time_24hr: true,
        locale: "fr",
        onValueUpdate: function(selectedDates, dateStr, instance) {
            console.log(dateStr)
            var date = dateStr.split("|")
            $("#departure_date").val(date[0].trim());
            $("#departure_time").val(date[1].trim());
        },
    });

    /*
    $(".flatpickr-hour").keyup(function() {
        if($(this).val() < 24) {
            $("#departure_date").val($(this).val() + ":" + $(".flatpickr-minute").val())
        }
    })


    $(".flatpickr-minute").keyup(function() {
        if($(this).val() < 60) {
            $("#departure_date").val($(".flatpickr-hour").val() + ":" + $(this).val())
        }
    })
    */


});
