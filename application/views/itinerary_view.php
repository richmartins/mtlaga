<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div id="home_container">
  <div>
    <div class="flex_container" id="itineraire_flex_header_title" >
      <div id="itineraire_flex_Header_direction">
        <p>Résultats</p>
      </div>
      <div class="flex_container" id="itineraire_flex_header_time">
          <input class="flatpickr_selector">
      </div>
        <div id="itineraire_flex_header_logo">
            <i class="fas fa-calendar-alt fa-lg"></i>
        </div>

    </div>
  </div>
  <div id="itineraire_flex_container_bck" >
    <div id="itineraire_flex_container">
      <?php
      if(!empty($connections)) {
          foreach ($connections as $connection_key => $connection) {
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
                          <div class="flex_container itineraire_flex_container_travel_time">
                              <p><?= $train_traject_length ?></p>
                          </div>
                          <div class="flex_container itineraire_flex_container_travel_change">
                              <p><?= $train_change ?></p>
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
                                          <p><b><?= $departure_station_section ?></b><?= $train_departure_platform ?>
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

                              <div class="flex_container itineraire_flex_container_travel_action">
                                  <div class="itineraire_flex_container_travel_action_perturbations">
                                      <p><b>Info trafic</b></p>
                                      <div>
                                          <p>Aucun dérangement n'est signalé</p>
                                      </div>
                                  </div>
                                  <div class="itineraire_flex_container_travel_action_outils">
                                      <p><b>Cette relation</b></p>
                                      <ul>
                                          <div class="flex_container itineraire_flex_container_travel_action_outils_icon">
                                              <li> Ajouter au favoris</li>
                                              <i class="fas fa-star"></i>
                                              <i class="fas fa-long-arrow-alt-right animated fadeInLeft"
                                                 style="display: none; padding-right: 5px"></i>
                                          </div>
                                          <div class="flex_container itineraire_flex_container_travel_action_outils_icon">
                                              <li> Afficher sur la carte</li>
                                              <i class="fas fa-map-marked-alt"></i>
                                              <i class="fas fa-long-arrow-alt-right animated fadeInLeft"
                                                 style="display: none; padding-right: 5px"></i>
                                          </div>
                                          <div class="flex_container itineraire_flex_container_travel_action_outils_icon">
                                              <li> Ajouter au calendrier</li>
                                              <i class="fas fa-calendar-alt"></i>
                                              <i class="fas fa-long-arrow-alt-right animated fadeInLeft"
                                                 style="display: none; padding-right: 5px"></i>
                                          </div>
                                      </ul>
                                  </div>
                              </div>
                          </div>

                          <?php
                          if ($section->arrival->station->name != end($connection->sections)->arrival->station->name) {
                              if (empty($connections[$connection_key]->sections[$section_key + 1]->walk)) {
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