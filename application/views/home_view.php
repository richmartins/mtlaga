<?php
    defined('BASEPATH') OR exit('No direct script access allowed');
    if(isset($_SESSION['email'])) {
        if(empty($user_favorites)) {
            $favorite_text = "Vous n'avez auncun favoris";
        }
    } else {
        $favorite_text = "Pour afficher ce contenu, vous devez être connecté";
    }

    foreach ($scripts_to_load as $script) {
        ?>
        <script type="text/javascript" src="<?= base_url(); ?>public/scripts/<?= $script; ?>.js"></script>
        <?php
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
       <form method="post" action="<?=base_url()?>itinerary/" id="searchItineraryForm">
            <div id="home_style_flexbox_container" class="flex_container">
                <div class="flex_container home_style_flexbox_fields_box" >
                    <select class="home_style_flexbox_fields js-data-example-ajax typeahead typeahead-departure" name="departure_city" data-placeholder="Ville de départ" >
                        <option></option>
                    </select>
                </div>
                <div class="flex_container" >
                    <select class="home_style_flexbox_fields js-data-example-ajax typeahead typeahead-arrival" name="arrival_city" data-placeholder="Ville d'arrivée" >
                        <option></option>
                    </select>
                </div>
                <div class="flex_container form_style_submit" >
                    <input type="button" class="home_style_flexbox_input" value="Rechercher" class="" type="text" >
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
        <?php if ($meta_data['connected']): ?>
          <div class="flex_container home_style_flexbox_sub_text" >
            <div class="home_text_rss">
              <?php if (empty($meta_data['rss'])): ?>
                <p style="text-align: center">Aucun dérangement à signaler</p>
              <?php else: ?>
                <?php foreach ($meta_data['rss'] as $k => $v): ?>
                  <p class="home_text_rss_title"><?= $k ?></p>
                  <p><?= $v ?></p>
                <?php endforeach; ?>
              <?php endif; ?>
            </div>
          </div>
        <?php else: ?>
          <div class="flex_container home_style_flexbox_sub_text" >
            <p style="text-align: center">Pour afficher ce contenu, vous devez être connecté</p>
          </div>
        <?php endif; ?>
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
                            <div class="flex_container" data-fav-departure="<?= $user_favorite->departure ?>" data-fav-arrival="<?= $user_favorite->arrival ?>">
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
                        <p id="home_style_flexbox_sub_text_field"><?= $favorite_text ?></p>
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
    /**
     * initialize Mapbox
     */
    mapboxgl.accessToken = 'pk.eyJ1IjoiaGFkcnlsb3VpcyIsImEiOiJjanIzYTl2Nzcwc3dqNDNxbXNkeWZuZmZhIn0.XyRFNfYowoHigvnxT6-0fA';
    const map = new mapboxgl.Map({
        container: 'home_style_flexbox_map',
        style: 'mapbox://styles/hadrylouis/cjrkquskq2t5c2so0ugcc6w25',
        center: [6.6327025, 46.5218269],
        zoom: 12.0,
        scrollZoom      : false,
        boxZoom         : false,
        doubleClickZoom : false
    });

    // add map navigation control
    map.addControl(new mapboxgl.NavigationControl());

    // Mapbox draw line
    map.on('load', function () {
        map.addLayer({
            "id": "route",
            "type": "line",
            "source": {
                "type": "geojson",
                "data": {
                    "type": "Feature",
                    "properties": {},
                    "geometry": {
                        "type": "LineString",
                        "coordinates": [
                            [6.631553682295134, 46.52056592321506],
                            [6.8422812934361446, 46.4613733860472],
                            [6.912896906372225, 46.43019320379772]
                        ]
                    }
                }
            },
            "layout": {
                "line-join": "round",
                "line-cap": "round"
            },
            "paint": {
                "line-color": "#f74242",
                "line-width": 3
            }
        });
    });

    $( document ).ready(function() {

        // initilize variables
        var departure_coordinates = []
        var arrival_coordinates = []
        var departure_marker = new mapboxgl.Marker();
        var arrival_marker = new mapboxgl.Marker();

        /**
         * initialize select2 on fields with typeahead class
         */
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
                            return {
                                id: obj.name,
                                text: obj.name,
                                x: obj.coordinate.x,
                                y: obj.coordinate.y
                            };
                        })
                    };
                },
            }
        });

        /**
         * Triggered when user select departure
         */
        $('.typeahead-departure').on('select2:select', function (e) {
            var data = e.params.data;

            /*
            if(data.x == null && data.y == null) {
                console.log("empty")
                data.x = map.getCenter().lat
                data.y = map.getCenter().lng
            }
            */

            departure_coordinates = [data.y, data.x];

            // Create HTMl Marker for departure and it place into map
            var el = document.createElement('div');
            el.className = 'marker'
            departure_marker.remove();
            departure_marker.setLngLat(departure_coordinates)
                .setPopup(new mapboxgl.Popup({ offset: 25 })
                .setHTML('<h3>Départ</h3><p>' + data.text + '</p>'));
            departure_marker.addTo(map);

            // test if arrival is already set
            if(arrival_coordinates.length == 0) {
                arrival_coordinates[0] = map.getCenter().lng
                arrival_coordinates[1] = map.getCenter().lat
            }

            mapBounds(departure_coordinates, arrival_coordinates)


        });

        /**
         * Triggered when user select arrival
         */
        $('.typeahead-arrival').on('select2:select', function (e) {
            var data = e.params.data;
            arrival_coordinates = [data.y, data.x];

            // Create HTMl Marker for arrival and place it into map
            var el = document.createElement('div');
            el.className = 'marker'
            arrival_marker.remove();
            arrival_marker.setLngLat(arrival_coordinates)
                .setPopup(new mapboxgl.Popup({ offset: 25 })
                .setHTML('<h3>Arrivée</h3><p>' + data.text + '</p>'));
            arrival_marker.addTo(map);

            // test if arrival is already set
            if(departure_coordinates.length == 0) {
                departure_coordinates[0] = map.getCenter().lng
                departure_coordinates[1] = map.getCenter().lat
            }

            mapBounds(departure_coordinates, arrival_coordinates)

        });

        /**
         * Bounds map to fit departure and arrival
         */
        function mapBounds(departure_coordinates, arrival_coordinates) {
            map.fitBounds([[
                departure_coordinates[0],
                departure_coordinates[1]
            ], [
                arrival_coordinates[0],
                arrival_coordinates[1]
            ]], {padding: 50});
        }

        /**
         * Favorite search itinerary
         * fill input for favorite and submit form -> redirect to itinerary
         */
        $(".home_style_flexbox_sub_text_scroll_container_title").click(function(){
            $("#header_notif_load").css('display', 'flex');
            $("#fav_departure").val($(this).children().children().eq(0).text())
            $("#fav_arrival").val($(this).children().children().eq(1).text())
            $("#fav_search").submit();
        })

        /**
         * Remove a user favorite -> call remove_favorite
         */
        $(".home_style_flexbox_sub_text_scroll_line_remove").click(function() {
            $("#header_notif_sucess").css('display', 'flex');

            var current = $(this)
            var fav_departure = $(this).parent().parent().parent().attr("data-fav-departure")
            var fav_arrival = $(this).parent().parent().parent().attr("data-fav-arrival")

            $.ajax(
                {
                    type:"post",
                    url: "<?php echo base_url(); ?>/itinerary/remove_favorite",
                    //dataType: "json",
                    data:{
                        departure:fav_departure,
                        arrival:fav_arrival
                    },
                    success:function(response)
                    {
                        $("#header_notif_load").css('display', 'none');

                        // if success : remove fav and send notif to user
                        // if error : send notif to user
                        if(response == "success") {
                            notif(response, "Favoris supprimé")
                            current.parent().parent().parent().remove()
                            if($(".home_style_flexbox_sub_text_scroll div").length == 0) {
                                $(".home_style_flexbox_sub_text_scroll").append('<p id="home_style_flexbox_sub_text_field">Vous n\'avez auncun favoris</p>')
                            }

                        } else if(response == "error") {
                            notif(response, "Erreur lors de la suppression")
                        }

                    }
                }
            );
        });

        /**
         * Check if fields are not empty and sumbit form -> search itinerary
         */
        $(".home_style_flexbox_input").click(function() {
            $("#header_notif_load").css('display', 'flex');

            var departure_city = $("select[name='departure_city']").text().trim().replace(/ /g, '%20')
            var arrival_city = $("select[name='arrival_city']").text().trim().replace(/ /g, '%20')

            // if fields empty : send error notif
            if(departure_city == "" || arrival_city == "") {
                notif("error", "Veuillez remplir les champs")
            } else {
                $("#searchItineraryForm").submit();
            }
        })
    });
</script>
