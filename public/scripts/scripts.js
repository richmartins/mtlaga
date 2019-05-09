

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

    $(".home_style_flexbox_sub_text_scroll_container_title").mouseover(function() {
        $(this).next().children().show()
        $(this).next().children(":nth-child(2)").hide()
    });

    $(".home_style_flexbox_sub_text_scroll_container_title").mouseleave(function() {
        $(this).next().children().hide()
        $(this).next().children(":nth-child(2)").show()
    });


    // init flartpickr sur classe flatpickr_selector
    flatpickr(".flatpickr_selector", {
        enableTime: true,
        dateFormat: "d.m.Y | H:i",
        time_24hr: true,
        locale: "fr",
        plugins: [new confirmDatePlugin()],
        onValueUpdate: function(selectedDates, dateStr, instance) {
            var date = dateStr.split("|")
            $("#departure_date").val(date[0].trim());
            $("#departure_time").val(date[1].trim());
        },
    });

    // force show confirm button flatpickr caldendar
    $(".flatpickr-confirm").addClass("visible");


    $(".flatpickr-confirm").click(function() {
        $("#searchItinerary").submit()
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
