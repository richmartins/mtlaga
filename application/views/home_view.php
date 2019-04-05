<?php
    defined('BASEPATH') OR exit('No direct script access allowed');
    if(isset($_SESSION['email'])) {
        if(empty($user_favorites)) {
            $favorite_text = "Vous n'avez auncun favoris";
        }
    } else {
        $favorite_text = "Pour afficher ce contenu, vous devez être connecté";
    }

?>
<div id="home_container">
  <div id="home_style_flexbox" class="flex_container">
    <div class="flex_container home_style_flexbox_head" >
      <div class="flex_container home_style_flexbox_title_container" >
        <div class="flex_container home_style_flexbox_title_text" >
          <p>Horaires</p>
        </div>
        <div class="flex_container" >
          <img class="home_style_flexbox_title_img" src="<?= base_url(); ?>public/img/mtlaga_home_clock.png" alt="">
        </div>
      </div>
        <form method="post" action="<?= base_url();?>Itinerary">
            <div id="home_style_flexbox_container" class="flex_container">
                <div class="flex_container home_style_flexbox_fields_box" >
                    <select class="home_style_flexbox_fields js-data-example-ajax typeahead" name="departure_city" data-placeholder="Ville de départ" >
                        <option></option>
                    </select>
                </div>
                <div class="flex_container" >
                    <select class="home_style_flexbox_fields js-data-example-ajax typeahead" name="arrival_city" data-placeholder="Ville d'arrivée" >
                        <option></option>
                    </select>
                </div>
                <div class="flex_container form_style_submit" >
                    <input type="submit" class="home_style_flexbox_input" value="Rechercher" class="" type="text">
                </div>
            </div>
            <input type="hidden" name="departure_date" >
            <input type="hidden" name="departure_time" >
        </form>
    </div>
    <div class="flex_container home_style_flexbox_head" >
        <div class="flex_container home_style_flexbox_title_container" >
            <div class="flex_container home_style_flexbox_title_text" >
                <p>Trafic</p>
            </div>
            <div class="flex_container">
                <img class="home_style_flexbox_title_img" src="<?= base_url(); ?>public/img/mtlaga_home_bell.png" alt="">
            </div>
        </div>
        <div class="flex_container home_style_flexbox_sub_text" >
            <p style="text-align: center">Pour afficher ce contenu, vous devez être connecté</p>
        </div>
    </div>
    <div class="flex_container home_style_flexbox_head" >
        <div class="flex_container home_style_flexbox_title_container" >
            <div class="flex_container home_style_flexbox_title_text" >
                <p>Favoris</p>
            </div>
            <div class="flex_container" >
                <img class="home_style_flexbox_title_img" src="<?= base_url(); ?>public/img/mtlaga_home_star.png" alt="">
            </div>
        </div>
        <div class="flex_container home_style_flexbox_sub_text">
            <form method="post" action="<?= base_url();?>Itinerary" id="fav_search">
                <input type="hidden" id="fav_departure" name="departure_city" value="">
                <input type="hidden" id="fav_arrival" name="arrival_city" value="">
                <input type="hidden" name="departure_date" >
                <input type="hidden" name="departure_time" >
                <ul class="home_style_flexbox_sub_text_scroll">
                    <?php

                    if(!empty($user_favorites)) {
                        foreach ($user_favorites as $user_favorite) {
                            ?>
                            <div class="flex_container">
                                <li class="home_style_flexbox_sub_text_scroll_container">
                                    <span class="home_style_flexbox_sub_text_scroll_container_title"><a class="home_style_flexbox_sub_text_scroll_container_link"><span class="fav_departure"><?= $user_favorite->departure ?></span> à <span class="fav_arrival"><?= $user_favorite->arrival ?></span></a></span>
                                    <div class="home_style_flexbox_sub_text_scroll_line">
                                        <span class="fas fa-long-arrow-alt-right  home_style_flexbox_sub_text_scroll_line_default animated fadeInLeft"></span>
                                        <span class="fas fa-times home_style_flexbox_sub_text_scroll_line_remove" ></span>
                                    </div>
                                </li>
                            </div>
                            <?php
                        }
                    } else {
                        ?>
                        <p style="text-align: center"><?= $favorite_text ?></p>
                        <?php
                    }

                    ?>
                </ul>
            </form>
        </div>
    </div>
  </div>
  <div id="home_style_flexbox_map_container" class="flex_container ">
      <div id="home_style_flexbox_map_border" class="flex_container">
          <div id='home_style_flexbox_map'></div>
      </div>
  </div>
</div>

<script>
    // affichage map
    mapboxgl.accessToken = 'pk.eyJ1IjoiaGFkcnlsb3VpcyIsImEiOiJjanIzYTl2Nzcwc3dqNDNxbXNkeWZuZmZhIn0.XyRFNfYowoHigvnxT6-0fA';
    const map = new mapboxgl.Map({
        container: 'home_style_flexbox_map',
        style: 'mapbox://styles/hadrylouis/cjrkquskq2t5c2so0ugcc6w25',
        center: [6.6327025, 46.5218269],
        zoom: 12.0,
        boxZoom: false,
    });

    // Init Select2 sur classe "typeahead"
    $( document ).ready(function() {
        $.fn.select2.defaults.set('language', 'fr');
        $('.typeahead').select2({
            ajax: {
                url: "http://transport.opendata.ch/v1/locations?",
                dataType: 'json',
                delay: 250,
                language: "fr",
                placeholder: function(){
                    $(this).data('placeholder');
                },
                method:'get',
                data: function (params) {
                    var query = {
                        query: params.term,
                    }
                    return query;
                },
                processResults: function (data) {
                    return {
                        results: $.map(data.stations, function(obj) {
                            return { id: obj.name, text: obj.name };
                        })
                    };
                },
            }
        });


        // fill input for favorite and submit form -> redirect to itinerary
        $(".home_style_flexbox_sub_text_scroll_container_link").click(function(){
            $("#fav_departure").val($(this).children().eq(0).text())
            $("#fav_arrival").val($(this).children().eq(1).text())
            $("#fav_search").submit();
        })

        // remove users's favorite
        $(".home_style_flexbox_sub_text_scroll_line_remove").click(function() {
            console.log("OK")

            $(this).parent().parent().remove()

        })


    });
</script>
