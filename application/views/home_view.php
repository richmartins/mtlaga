<?php
<<<<<<< HEAD
  defined('BASEPATH') OR exit('No direct script access allowed');
=======
    defined('BASEPATH') OR exit('No direct script access allowed');
    if(isset($_SESSION['email'])) {
        if(empty($user_favorites)) {
            $favorite_text = "Vous n'avez auncun favoris";
        }
    } else {
        $favorite_text = "Pour afficher ce contenu, vous devez être connecté";
    }

>>>>>>> c0b88f79c886d1d0920c16c03c223c7cf8fc1be6
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
<<<<<<< HEAD
            <p style="text-align: center">Pour afficher ce contenu, vous devez être connecté</p>
=======
            <ul class="home_style_flexbox_sub_text_scroll">
            <?php

            if(!empty($user_favorites)) {
                foreach ($user_favorites as $user_favorite) {
                    ?>
                    <li><?= $user_favorite->departure ?> à <?= $user_favorite->arrival ?></li>
                    <?php
                }
            } else {
                ?>
                <p style="text-align: center"><?= $favorite_text ?></p>
            <?php
            }

            ?>
            </ul>
>>>>>>> c0b88f79c886d1d0920c16c03c223c7cf8fc1be6
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
<<<<<<< HEAD
=======
        $.fn.select2.defaults.set('language', 'fr');
>>>>>>> c0b88f79c886d1d0920c16c03c223c7cf8fc1be6
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
    });
</script>