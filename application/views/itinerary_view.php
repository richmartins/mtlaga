<?php
defined('BASEPATH') OR exit('No direct script access allowed');

foreach ($scripts_to_load as $script) {
    ?>
    <script type="text/javascript" src="<?= base_url(); ?>public/scripts/<?= $script; ?>.js"></script>
<?php
}

// check if user is connected
$connected = false;
if($this->meta_data['connected'] == 1) {
    $connected = true;
}

$is_favorite = false;
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
?>

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
                <div class="flex_container itineraire_header_action_favorite" >
                    <p><span id="itineraire_toggle_fav" class="itineraire_header_action_hover">Supprimer ce trajet des favoris</span></p>
                    <i class="fas fa-star itineraire_header_action_favorite_icon" style="color: gold" ></i>
                </div>
            <?php
            } else {
                ?>
                <div class="flex_container itineraire_header_action_favorite" >
                    <p><span id="itineraire_toggle_fav" class="itineraire_header_action_hover">Ajouter ce trajet aux favoris</span></p>
                    <i class="fas fa-star itineraire_header_action_favorite_icon" ></i>
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
              <div class="itineraire_flex_container_travel_bck" id="">
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
                              <div class="flex_container itineraire_flex_container_travel_action">
                                  <div class="itineraire_flex_container_travel_action_perturbations">
                                      <p><b>Info trafic</b></p>
                                      <div>
                                          <p>Aucun dérangement n'est signalé</p>
                                      </div>
                                  </div>
                                  <?php

                                  $style = "";
                                  if (!$connected) {
                                      $style = "opacity: 0.5; pointer-events: none;";
                                  }
                                  ?>
                                  <div class="itineraire_flex_container_travel_action_outils" style="<?= $style ?>">
                                      <p><b>Cette relation</b></p>
                                      <ul>
                                          <div class="flex_container itineraire_flex_container_travel_action_outils_icon icon_toggle_favorite">
                                              <i class="fas fa-long-arrow-alt-right animated fadeInLeft"
                                                 style="display: none; padding-right: 5px"></i>
                                              <input type="hidden" data-journey="<?= $departure_station_section ?>"
                                                     value="<?= $departure_station_section ?>">
                                              <input type="hidden" data-journey="<?= $arrival_station_section ?>"
                                                     value="<?= $arrival_station_section ?>">
                                          </div>
                                          <div class="flex_container itineraire_flex_container_travel_action_outils_icon icon_show_map">
                                              <li> Afficher sur la carte</li>
                                              <i class="fas fa-map-marked-alt"></i>
                                              <i class="fas fa-long-arrow-alt-right animated fadeInLeft"
                                                 style="display: none; padding-right: 5px"></i>
                                          </div>
                                          <div class="flex_container itineraire_flex_container_travel_action_outils_icon icon_add_calendar">
                                              <li> Ajouter au calendrier</li>
                                              <i class="fas fa-calendar-alt"></i>
                                              <i class="fas fa-long-arrow-alt-right animated fadeInLeft"
                                                 style="display: none; padding-right: 5px"></i>
                                          </div>
                                          <div class="flex_container itineraire_flex_container_travel_action_outils_icon">
                                              <?php
                                              if (is_null($train_departure_platform)) {
                                                  $train_arrival_platform = "";
                                              }
                                              $arrival_platform = ", Voie " . end($connection->sections)->arrival->platform;
                                              if(is_null(end($connection->sections)->arrival->platform)) {
                                                  $arrival_platform = "";
                                              }
                                              ?>
                                              <li><a href="mailto:?subject=Voyage%20de%20<?= $api->from->name ?>%20%C3%A0%20<?= $api->to->name ?>&amp;body=D%C3%A9tails%20de%20votre%20voyage%20du%20<?= date('d.m.Y', strtotime($date)) ?>%20%3A%20%0A%0AD%C3%A9part%20%3A%20<?= $departure_time_section ?>%20de%20<?= $api->from->name ?>%20<?= $train_departure_platform ?>%20%0AArriv%C3%A9e%20%3A%20<?= date('H:i', $connection->to->arrivalTimestamp) ?>%A0%20%C3%A0%20<?= $api->to->name ?>%20<?= $arrival_platform ?>%0A%0APour%20plus%20de%20d%C3%A9tails%20%3A%20http://www.mtlaga.ch">Envoyer par mail</a></li>
                                              <i class="fas fa-envelope"></i>
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

<script>
    // Ajax request to add journey to user's favourite
    $( document ).ready(function() {

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
