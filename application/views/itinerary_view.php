<?php
defined('BASEPATH') OR exit('No direct script access allowed');

foreach ($scripts_to_load as $script) {
    ?>
    <script type="text/javascript" src="<?= base_url(); ?>public/scripts/<?= $script; ?>.js"></script>
<?php
}

// Force redirect if no itinerary search
if(!isset($api) || empty($api->connections)) {
    redirect('Home');
}

// check if user is connected
$connected = false;
$is_favorite = false;
$style = "opacity: 0.5; pointer-events: none;";

if($this->meta_data['connected'] == 1) {
    $connected = true;
    $style = "";

    $journey = [
        "departure" => $api->from->name,
        "arrival" => $api->to->name
    ];

    // check if journey is favorite
    foreach ($favorites as $favorite) {
        //if(array)
        $favorite = [
            "departure" => $favorite->departure,
            "arrival" => $favorite->arrival
        ];
        if(empty(array_diff($journey, $favorite))) {
            $is_favorite = true;
        }
    }
}

?>
<!-- map modal -->
<div id="map-container" class="modal">
    <?php
    if($connected) {
        ?>
        <div class="modal-header">
            <i class="fas fa-times fa-lg map-close"></i>
        </div>
        <div id="map" class="modal-container">
        </div>
    <?php
    }
    ?>
</div>

<div id="modal-mail" class="modal">
    <?php
    if($connected) {
       ?>
        <div class="modal-header">
            <i class="fas fa-times fa-lg map-close"></i>
        </div>
        <div class="modal-container">
            <div class="modal-bck">
                <div style="padding: 10px">
                    <h2 class="modal-h2-title">Envoyer par email</h2>
                    <input type="hidden" value="" id="section-id">
                    <form method="post" id="send-mail">
                        <h3 class="model-h3-title">Liste des destinataires</h3>
                        <select required type="text" multiple class="form_input" id="modal-email-tag"></select>
                        <br>
                        <span>M'ajouter comme destinataire</span>
                        <input type="checkbox" id="modal-email-me">
                        <br>
                        <h3 class="modal-h3-title">Votre message</h3>
                        <textarea class="modal-textarea" id="modal-email-message"></textarea>
                        <br><br>
                        <button class="modal-button">Envoyer</button>
                    </form>
                </div>
            </div>
        </div>
    <?php
    }
    ?>
</div>

<div id="home_container_overlay"></div>
    <div id="home_container">
        <!-- Action block -->
        <div style="background-color: white; box-shadow: 0 2px 6px rgba(0,0,0,.2); margin-bottom: 20px" class="flex_container">
            <div class="flex_container itineraire_header_action" >
                <div class="flex_container itineraire_header_action_search" >
                    <i class="fas fa-arrow-left itineraire_header_action_search_icon"></i>
                    <p>
                        <span >
                            <a class="itineraire_header_action_hover" href="<?= base_url();?>">Nouvelle recherche</a>
                        </span>
                    </p>
                </div>
                <?php
                if($is_favorite) {
                    ?>
                    <div class="flex_container itineraire_header_action_favorite" style="<?= $style ?>" >
                        <p><span id="itineraire_toggle_fav" class="itineraire_header_action_hover">Supprimer ce trajet des favoris</span></p>
                        <i class="fas fa-star itineraire_header_action_favorite_icon" style="color: gold" ></i>
                    </div>
                <?php
                } else {
                    ?>
                    <div class="flex_container" id="itineraire_header_action_favorite_bck" data-user="<?= $connected ?>">
                        <div class="flex_container itineraire_header_action_favorite" style="<?= $style ?> width: 100%;" >
                            <p><span id="itineraire_toggle_fav" class="itineraire_header_action_hover">Ajouter ce trajet aux favoris</span></p>
                            <i class="fas fa-star itineraire_header_action_favorite_icon" ></i>
                        </div>
                    </div>
                <?php
                }
                ?>

            </div>
        </div>

      <div>
        <div class="flex_container" id="itineraire_flex_header_title" >
          <div id="itineraire_flex_Header_direction">
            <p>Résultats</p>
          </div>
            <div id="itineraire_flex_header_time_container">
                <form method="post" action="<?= base_url();?>Itinerary" id="searchItinerary">
                    <input type="hidden" value="<?= $api->from->name ?>" name="departure_city">
                    <input type="hidden" value="<?= $api->to->name ?>" name="arrival_city">
                    <input type="hidden" value="<?= date("d-m-Y", strtotime($date)) ?>" name="departure_date" id="departure_date">
                    <input type="hidden" value="<?= $time ?>" name="departure_time" id="departure_time">
                    <div class="flex_container">
                        <div class="flex_container" id="itineraire_flex_header_time">
                            <input class="flatpickr_selector" value="<?= date("d-m-Y", strtotime($date))?> | <?= $time ?>">
                        </div>
                        <div id="itineraire_flex_header_logo">
                            <i class="fas fa-calendar-alt fa-lg"></i>
                        </div>
                    </div>
                </form>
            </div>
        </div>
      </div>
      <div id="itineraire_flex_container_bck" >
        <div id="itineraire_flex_container">
          <?php
          if(!empty($api->connections)) {
              foreach ($api->connections as $connection_key => $connection) {
                  // Départ du train
                  $train_departure = date('H:i', $connection->from->departureTimestamp);
                  // Arrivée du train
                  $train_arrival = date('H:i', $connection->to->arrivalTimestamp);
                  // Durée trajet
                  $train_traject_length = substr($connection->duration, 3);
                  // Nombre changement
                  $train_change = $connection->transfers . " Changements";
                  // Ville départ
                  $train_departure_city = $connection->from->station->name;
                  // Ville départ
                  $train_arrival_city = $connection->to->station->name;

                  ?>

                  <!-- Traject line !-->
                  <div class="itineraire_flex_container_travel_bck">
                      <div class="itineraire_flex_container_travel">
                          <div class="itineraire_flex_container_travel_text">
                              <p>
                                  <?= $train_departure_city ?>
                                  <i class="fas fa-long-arrow-alt-right"></i>
                                  <?= $train_arrival_city ?>
                              </p>
                          </div>
                          <div class="flex_container itineraire_flex_container_travel_container">
                              <div class="flex_container itineraire_flex_container_travel_now">
                                  <div>
                                      <div><p><?= $train_departure ?></p></div>
                                      <div><p><b><?= $train_departure_city ?></b></p></div>
                                  </div>
                                  <div class="itineraire_flex_container_travel_line">
                                      <span class="dot dot_start"></span>
                                      <span class="dot dot_end"></span>
                                  </div>
                                  <div>
                                      <div><p><?= $train_arrival ?></p></div>
                                      <div><p><b><?= $train_arrival_city ?></b></p></div>
                                  </div>
                              </div>
                              <div style="display: flex; width: 100%; padding-top: 7px; padding-bottom: 7px;">
                                  <div class="flex_container itineraire_flex_container_travel_time" style="width: 50%">
                                      <p><?= $train_traject_length ?></p>
                                  </div>
                                  <div class="flex_container itineraire_flex_container_travel_change" style="width: 50%">
                                      <p><?= $train_change ?></p>
                                  </div>
                              </div>
                              <div class="flex_container itineraire_flex_container_travel_more">
                                  <a>
                                      <div class="fas fa-plus fa-lg itineraire_flex_container_travel_accordion itineraire_flex_container_travel_rotate"></div>
                                  </a>
                              </div>
                          </div>
                      </div>
                  </div>

                  <!-- Details trajet -->
                  <div class="itineraire_flex_container_travel_panel flex_container">
                      <?php
                      $section_loop = 0;
                      foreach ($connection->sections as $section_key => $section) {
                          // Heures départ/arrivée de la section
                          $departure_time_section = date('H:i', $section->departure->departureTimestamp);
                          $arrival_time_section = date('H:i', $section->arrival->arrivalTimestamp);

                          // durée de la section
                          $section_duration = $section->arrival->arrivalTimestamp - $section->departure->departureTimestamp;
                          $section_duration_formatted = date("H:i", $section_duration - 3600);

                          // Formatage date pour affichage humain
                          $section_duration_hours = $section_duration / 3600 % 24;
                          $section_duration_minutes = $section_duration / 60 % 60;
                          $section_duration_formatted_walk = "Marche " . $section_duration_hours . " heures " . $section_duration_minutes . " minutes";
                          $section_duration_formatted_small = "<b>" . $section_duration_hours . "</b> h <b>" . $section_duration_minutes . "</b> min";
                          if (empty($section_duration_hours)) {
                              $section_duration_formatted_walk = "Marche " . $section_duration_minutes . " minutes";
                              $section_duration_formatted_small = "<b>" . $section_duration_minutes . "</b> min";
                          }

                          // Départ / Arrivée de la section
                          $departure_station_section = $section->departure->station->name;
                          $arrival_station_section = $section->arrival->station->name;

                          if (!empty($section->journey)) {
                              // direction finale du transport
                              $section_transport_direction = $section->journey->to;
                              $train_departure_platform = "";
                              $train_arrival_platform = "";

                              $section_loop += 1;

                              // Quai de départ
                              if (!empty($section->departure->platform)) {
                                  $train_departure_platform = ", Voie " . $section->departure->platform;
                              }
                              // Quai d'arrivée
                              if (!empty($section->arrival->platform)) {
                                  $train_arrival_platform = ", Voie " . $section->arrival->platform;
                              }

                              // tableau correspondance icones
                              $transport_type = [
                                  "BAT" => "ship",
                                  "BUS" => "bus",
                                  "T" => "train",
                                  "M" => "train",
                                  "FUN" => "train"
                              ];

                              $icon = "subway";
                              if (array_key_exists($section->journey->category, $transport_type)) {
                                  $icon = $transport_type[$section->journey->category];
                              }

                              // Numéro du transport
                              $section_transport_number = $section->journey->category . " " . $section->journey->number;
                              if ($section->journey->category == "FUN"
                                  || $section->journey->category == "BAT"
                                  || $section->journey->category == "EC"
                                  || $section->journey->category == "RE"
                              ) {
                                  $section_transport_number = $section->journey->name;
                              } else if ($section->journey->category == "M") {
                                  $section_transport_number = $section->journey->number;
                              }

                              ?>

                              <!-- Bloc trajet point A vers point B -->
                              <div class="itineraire_flex_container_travel_details flex_container">
                                  <div class="flex_container itineraire_flex_container_travel_details_container">
                                      <div class="itineraire_flex_container_travel_details_hours">
                                          <div class="itineraire_flex_container_travel_details_hours_start">
                                              <p><?= $departure_time_section ?></p>
                                          </div>
                                          <div class="itineraire_flex_container_travel_details_end">
                                              <p><?= $arrival_time_section ?></p>
                                          </div>
                                      </div>
                                      <div class="itineraire_flex_container_travel_details_line">
                                          <span class="dot dot_start_details"></span>
                                          <svg height="170" width="30">
                                              <g fill="none">
                                                  <path stroke="red" d="M 0 0 L 0 200 " stroke-width="5"/>
                                              </g>
                                          </svg>
                                          <span class="dot dot_end_details"></span>
                                      </div>
                                      <div class="itineraire_flex_container_travel_details_box">
                                          <div class="flex_container itineraire_flex_container_travel_details_start">
                                              <p class="departure_station_section"><b><?= $departure_station_section ?></b><?= $train_departure_platform ?>
                                              </p>
                                          </div>
                                          <div class="flex_container itineraire_flex_container_travel_details_infos">
                                              <div><i class="fas fa-<?= $icon ?> fa-lg"></i>
                                                  <b><?= $section_transport_number ?></b> Direction
                                                  <b><?= $section_transport_direction ?></b></div>
                                              <div><p><?= $section_duration_formatted_small; ?></p></div>
                                          </div>
                                          <div class="itineraire_flex_container_travel_details_end flex_container">
                                              <p><b><?= $arrival_station_section ?></b><?= $train_arrival_platform ?></p>
                                          </div>
                                      </div>
                                  </div>

                                  <?php

                                  if($section_loop == 1) {
                                  ?>
                                  <div class="flex_container itineraire_flex_container_travel_action" data-user="<?= $connected ?>">
                                      <?php

                                      $style = "";
                                      if (!$connected) {
                                          $style = "opacity: 0.5; pointer-events: none;";
                                          ?>
                                          <div class="itineraire_flex_container_travel_login" >Veuillez vous connecter</div>
                                          <?php
                                      }
                                      ?>
                                      <div class="itineraire_flex_container_travel_action_outils" style="<?= $style ?>">
                                          <p class="itineraire_flex_container_action_outil_text"><b>Cette relation</b></p>
                                          <ul>
                                              <div class="flex_container itineraire_flex_container_travel_action_outils_icon icon_show_map">
                                                  <li class="itineraire_flex_container_action_outil_text">Afficher sur la carte</li>
                                                  <i class="fas fa-map-marked-alt itineraire_icon"></i>
                                                  <i class="fas fa-long-arrow-alt-right animated fadeInLeft"
                                                     style="display: none; padding-right: 5px"></i>
                                                  <input type="hidden" value="<?= $connection_key ?>">
                                              </div>
                                              <div class="flex_container itineraire_flex_container_travel_action_outils_icon icon_add_calendar">
                                                  <li class="itineraire_flex_container_action_outil_text"><a href="<?= base_url()?>/Itinerary/generate_ics/toto/tata">Ajouter au calendrier</a></li>
                                                  <i class="fas fa-calendar-alt itineraire_icon"></i>
                                                  <i class="fas fa-long-arrow-alt-right animated fadeInLeft"
                                                     style="display: none; padding-right: 5px">
                                                  </i>
                                              </div>
                                              <div class="flex_container itineraire_flex_container_travel_action_outils_icon send_email" data-index="<?= $connection_key?>">
                                                  <?php
                                                  /*
                                                  if (is_null($train_departure_platform)) {
                                                      $train_arrival_platform = "";
                                                  }
                                                  $arrival_platform = ", Voie " . end($connection->sections)->arrival->platform;
                                                  if(is_null(end($connection->sections)->arrival->platform)) {
                                                      $arrival_platform = "";
                                                  }*/
                                                  ?>
                                                  <li class="itineraire_flex_container_action_outil_text"><a>Envoyer par email</a></li>
                                                  <i class="fas fa-envelope itineraire_icon"></i>
                                                  <i class="fas fa-long-arrow-alt-right animated fadeInLeft" style="display: none; padding-right: 5px"></i>
                                              </div>
                                          </ul>
                                      </div>
                                  </div>
                                      <?php
                                  }
                                      ?>

                              </div>

                              <?php
                              if ($section->arrival->station->name != end($connection->sections)->arrival->station->name) {
                                  if (empty($api->connections[$connection_key]->sections[$section_key + 1]->walk)) {
                                      ?>
                                      <!--Bloc changement-->
                                      <div class="itineraire_flex_container_travel_details_walk">
                                          <div class="flex_container">
                                              <i class="fas fa-walking fa-lg"></i>
                                              <p> Changement</p>
                                          </div>
                                      </div>
                                      <?php
                                  }
                              }

                          } else {
                              ?>
                              <!-- Bloc marche -->
                              <div class="itineraire_flex_container_travel_details_walk">
                                  <div class="flex_container">
                                      <i class="fas fa-walking fa-lg"></i>
                                      <p><?= $section_duration_formatted_walk; ?></p>
                                  </div>
                              </div>
                              <?php
                          }
                      }
                      ?>
                  </div>
                  <?php
              }
          } else {
              echo "Aucun résulat trouvé pour cette relation";
          }
          ?>

        </div>
      </div>
    </div>
</div>
<script type="text/javascript">

    /**
     * initialize Mapbox
     */
    mapboxgl.accessToken = 'pk.eyJ1IjoiaGFkcnlsb3VpcyIsImEiOiJjanIzYTl2Nzcwc3dqNDNxbXNkeWZuZmZhIn0.XyRFNfYowoHigvnxT6-0fA';
    const map = new mapboxgl.Map({
        container: 'map',
        style: 'mapbox://styles/hadrylouis/cjrkquskq2t5c2so0ugcc6w25',
        center: [6.6327025, 46.5218269],
        zoom: 12.0,
        scrollZoom      : false,
        boxZoom         : false,
        doubleClickZoom : false
    });
    map.addControl(new mapboxgl.NavigationControl());
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
                        "coordinates": []
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

    // Ajax request to add journey to user's favourite
    $( document ).ready(function() {

        var api = <?= json_encode($api); ?>

        var lines = []
        var geojson = []

        $('.icon_show_map').click(function() {
            var index = $(this).children().next().eq(2).val()
            $("#home_container_overlay").css('display', 'block');

            //console.log(api)

            // fill lines with journey stops
            var departure_marker = new mapboxgl.Marker();
            var departure_coordinates = []
            var sections = api.connections[index].sections
            sections.forEach(function(v, k) {
                if(v.journey !== null) {
                    v.journey.passList.forEach(function(v2,k2) {
                        lines.push([v2.station.coordinate.y, v2.station.coordinate.x])
                    })
                } else {
                    lines.push([v.departure.station.coordinate.y, v.departure.station.coordinate.x])
                }
                if(v.walk === null) {
                    // create marker
                }
            })
            lines.push([sections[sections.length-1]['arrival']['location']['coordinate']['y'], sections[sections.length-1]['arrival']['location']['coordinate']['x']])


            // add layer
            geojson = {
                "type": "FeatureCollection",
                "features": [{
                    "type": "Feature",
                    "geometry": {
                        "type": "LineString",
                        "coordinates": lines
                    }
                }]
            };
            map.getSource('route').setData(geojson);

            var last_index = lines[lines.length-1]

            // show map / resize / fit bounds
            $("#map-container").css('display', 'block')
            map.resize()
            //map.fitBounds(lines, {padding: 50});

            map.fitBounds([[
                lines[0][0],
                lines[0][1]
            ], [
                last_index[0],
                last_index[1]
            ]], {padding: 50});

            // sortir relation courante et tous les arrêts
        });

        /**
         * Hide itinerary map
         * Close Modal
         */
        $(".map-close").click(function() {
            $(".modal").css('display', 'none');
            $("#home_container_overlay").css('display', 'none');
            lines = []
        })

        /**
         * Open send email modal
         */
        $(".send_email").click(function() {
            $("#home_container_overlay").css('display', 'block');
            $("#modal-mail").css('display', 'block')

            // set id to modal
            var index = $(this).attr("data-index")
            $("#section-id").val(index)
        })

        /**
         * Initialize select2 email modal
         */
        $("#modal-email-tag").select2({
            tags: true,
            language: "fr",
            tokenSeparators: [',', ' ']
        })

        /**
         * Add favorite but not connected error message
         */
        $("#itineraire_header_action_favorite_bck").click(function() {
            if($(this).attr('data-user') == false){
                notif('error', "Vous devez être connecté")
            }
        })

        /**
         * Itinerary click action but not connected error message
         */
        $(".itineraire_flex_container_travel_action").click(function() {
            if($(this).attr('data-user') == false){
                notif('error', "Vous devez être connecté")
            }
        })

        /**
         * Send Mail function - AJAX to CI
         */
        $("#send-mail").submit(function(e){
            e.preventDefault();
            var recipents = $("#modal-email-tag").val()

            var me = $("#modal-email-me")
            if (me.is(":checked")) {
              me = true;
            } else {
              me = false;
            }

            $.ajax(
                {
                    type: "post",
                    url: "<?= base_url(); ?>itinerary/check_sendEmail_travel",
                    data: {
                        recipents: recipents,
                        message: $("#modal-email-message").val(),
                        journey: api.connections[$("#section-id").val()],
                        me: me
                    },
                    success: function (response) {
                        $(".modal").css('display', 'none');
                        $("#home_container_overlay").css('display', 'none');
                        notif('success', 'Mail envoyé avec succès')
                    },
                    error: function (response) {
                      notif('error', 'Erreur lors de l\'envoi du mail')
                    }
                });
        });

        /**
         * Toggle favorite to user
         */
        $("#itineraire_toggle_fav").click(function(){
            var departure_city = $('input[name=departure_city]').val()
            var arrival_city = $('input[name=arrival_city]').val()
            var current = $(this)

            $.ajax(
                {
                    type:"post",
                    url: "<?php echo base_url(); ?>/itinerary/toggle_favorite",
                    data:{
                        departure:departure_city,
                        arrival:arrival_city
                    },
                    success:function(response) {
                        var notif_text = "";
                        var notif_state = "";
                        switch(response) {
                            case "remove-success":
                                notif_text = "Le favori a bien été supprimé"
                                notif_state = "success"
                                current.parent().next().css('color', 'black')
                                current.text("Ajouter ce trajet aux favoris")
                                break;
                            case "remove-error":
                                notif_text = "Erreur lors de la suppression du favori"
                                notif_state = "error"
                                break;
                            case "add-success":
                                notif_text = "Le favori a bien été ajouté"
                                notif_state = "success"
                                current.parent().next().css('color', 'gold')
                                current.text("Supprimer ce trajet des favoris")
                                break;
                            case "add-error":
                                notif_text = "Erreur lors de l'ajout du favori"
                                notif_state = "error"
                                break;
                        }
                        notif(notif_state, notif_text)

                    },
                    error: function(jqXHR, textStatus, errorThrown) {

                        notif("error", "Erreur lors de l'ajout du favori")

                    }
                }
            );
        })
    });
</script>
