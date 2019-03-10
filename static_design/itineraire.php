<?php
include("header.html");
?>
<div id="home_container">
  <div>
    <div class="flex_container" id="itineraire_flex_header_title" >
      <div id="itineraire_flex_Header_direction">
        <p>Résultats</p>
      </div>
      <div class="flex_container" id="itineraire_flex_header_time">
          <p>15:56 | 02.02.2019</p>
      </div>
        <div id="itineraire_flex_header_logo">
            <img src="./img/mtlaga_calendar.png" alt="calendar">
        </div>

    </div>
  </div>
  <div id="itineraire_flex_container_bck" >
    <div id="itineraire_flex_container">
      <?php
      // Départ du train
      $train_departure = "07:00";
      // Arrivée du train
      $train_arrival = "07:42";
      // Durée trajet
      $train_traject_length = "2 h 6 min";
      // Nombre changement
      $train_change = "3 Changements";
      // Ville départ
      $train_departure_city = "Neuhausen am Rheinfall";
      // Ville départ
      $train_arrival_city = "	Neuhausen am Rheinfall";
      // Quai de départ
      $train_departure_platform = "Voie 2";
      // Quai d'arrivée
      $train_arrival_platform = "Voie 1";
      // Direction du train
      $train_direction = "Brig";
      // Numéro du train
      $train_number = "IR 90";

      for($i = 0; $i < 15; $i++) {
        ?>

        <!-- Traject line !-->
        <div class="itineraire_flex_container_travel_bck" id="<?= $i ?>">
          <div class="itineraire_flex_container_travel">
            <div class="itineraire_flex_container_travel_text">
                <p>
                    <?= $train_departure_city ?>
                    <i class="fas fa-long-arrow-alt-right"></i>
                    <?= $train_arrival_city ?>
                </p>
            </div>
            <div class="flex_container itineraire_flex_container_travel_container" >
              <div class="flex_container itineraire_flex_container_travel_now">
                <div>
                    <div><p><?= $train_departure ?></p></div>
                    <div><p><b><?= $train_departure_city ?></b></p></div>
                </div>
                <div class="itineraire_flex_container_travel_line">
                  <span class="dot dot_start"></span>
                    <!--
                  <svg height="30" width="200">
                   <g fill="none">
                     <path stroke="red" d="M0 20 l200 0" stroke-width="3" />
                   </g>
                  </svg>
                  -->
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
                  <a><div class="fas fa-plus fa-lg itineraire_flex_container_travel_accordion itineraire_flex_container_travel_rotate"></div></a>
              </div>
            </div>
          </div>
        </div>

        <!-- Details trajet -->
        <div class="itineraire_flex_container_travel_panel flex_container">
              <!-- Bloc trajet point A vers point B -->
              <div class="itineraire_flex_container_travel_details flex_container">
                  <div class="flex_container itineraire_flex_container_travel_details_container">
                      <div class="itineraire_flex_container_travel_details_hours">
                          <div class="itineraire_flex_container_travel_details_hours_start">
                              <p><?= $train_departure ?></p>
                          </div>
                          <div class="itineraire_flex_container_travel_details_end">
                              <p><?= $train_arrival ?></p>
                          </div>
                      </div>
                      <div class="itineraire_flex_container_travel_details_line">
                          <span class="dot dot_start_details"></span>
                          <svg height="170" width="30">
                              <g fill="none">
                                  <path stroke="red" d="M 0 0 L 0 200 " stroke-width="5" />
                              </g>
                          </svg>
                          <span class="dot dot_end_details"></span>
                      </div>
                      <div class="itineraire_flex_container_travel_details_box">
                          <div class="flex_container itineraire_flex_container_travel_details_start">
                              <p><b><?= $train_departure_city ?></b><?= ", " . $train_departure_platform ?></p>
                          </div>
                          <div class="flex_container itineraire_flex_container_travel_details_infos">
                              <div><i class="fas fa-train fa-lg"></i> <b><?= $train_number ?></b> Direction <b><?= $train_direction ?></b></div>
                              <div><p><b>42</b> min</p></div>
                          </div>
                          <div class="itineraire_flex_container_travel_details_end flex_container">
                              <p><b><?= $train_arrival_city ?></b><?= ", " . $train_arrival_platform ?></p>
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
                                  <i class="fas fa-long-arrow-alt-right animated fadeInLeft" style="display: none; padding-right: 5px"></i>
                              </div>
                              <div class="flex_container itineraire_flex_container_travel_action_outils_icon">
                                  <li> Afficher sur la carte</li>
                                  <i class="fas fa-map-marked-alt"></i>
                                  <i class="fas fa-long-arrow-alt-right animated fadeInLeft" style="display: none; padding-right: 5px"></i>
                              </div>
                              <div class="flex_container itineraire_flex_container_travel_action_outils_icon">
                                  <li> Ajouter au calendrier</li>
                                  <i class="fas fa-calendar-alt"></i>
                                  <i class="fas fa-long-arrow-alt-right animated fadeInLeft" style="display: none; padding-right: 5px"></i>
                              </div>
                          </ul>
                      </div>
                  </div>
              </div>

              <!-- Bloc marche -->
              <div class="itineraire_flex_container_travel_details_walk" >
                  <div class="flex_container">
                      <i class="fas fa-walking fa-lg"></i><p> Marche 5 minutes</p>
                  </div>
              </div>

              <!-- Bloc trajet point A vers point B -->
              <div class="itineraire_flex_container_travel_details flex_container">
                  <div class="flex_container itineraire_flex_container_travel_details_container">
                      <div class="itineraire_flex_container_travel_details_hours">
                          <div class="itineraire_flex_container_travel_details_hours_start">
                              <p><?= $train_departure ?></p>
                          </div>
                          <div class="itineraire_flex_container_travel_details_end">
                              <p><?= $train_arrival ?></p>
                          </div>
                      </div>
                      <div class="itineraire_flex_container_travel_details_line">
                          <span class="dot dot_start_details"></span>
                          <svg height="170" width="30">
                              <g fill="none">
                                  <path stroke="red" d="M 0 0 L 0 200 " stroke-width="5" />
                              </g>
                          </svg>
                          <span class="dot dot_end_details"></span>
                      </div>
                      <div class="itineraire_flex_container_travel_details_box">
                          <div class="flex_container itineraire_flex_container_travel_details_start">
                              <p><b><?= $train_departure_city ?></b><?= ", " . $train_departure_platform ?></p>
                          </div>
                          <div class="flex_container itineraire_flex_container_travel_details_infos">
                              <div><i class="fas fa-train fa-lg"></i> <b><?= $train_number ?></b> Direction <b><?= $train_direction ?></b></div>
                              <div><p><b>42</b> min</p></div>
                          </div>
                          <div class="itineraire_flex_container_travel_details_end flex_container">
                              <p><b><?= $train_arrival_city ?></b><?= ", " . $train_arrival_platform ?></p>
                          </div>
                      </div>
                  </div>

                  <div class="flex_container itineraire_flex_container_travel_action">
                      <div class="itineraire_flex_container_travel_action_perturbations">
                          <p><b>Info trafic</b></p>
                          <p>Aucun dérangement n'est signalé</p>
                      </div>
                      <div class="itineraire_flex_container_travel_action_outils">
                          <p><b>Cette relation</b></p>
                          <ul>
                              <div class="flex_container itineraire_flex_container_travel_action_outils_icon">
                                  <li> Ajouter au favoris</li>
                                  <i class="fas fa-star"></i>
                                  <i class="fas fa-long-arrow-alt-right animated fadeInLeft" style="display: none; padding-right: 5px"></i>
                              </div>
                              <div class="flex_container itineraire_flex_container_travel_action_outils_icon">
                                  <li> Afficher sur la carte</li>
                                  <i class="fas fa-map-marked-alt"></i>
                                  <i class="fas fa-long-arrow-alt-right animated fadeInLeft" style="display: none; padding-right: 5px"></i>
                              </div>
                              <div class="flex_container itineraire_flex_container_travel_action_outils_icon">
                                  <li> Ajouter au calendrier</li>
                                  <i class="fas fa-calendar-alt"></i>
                                  <i class="fas fa-long-arrow-alt-right animated fadeInLeft" style="display: none; padding-right: 5px"></i>
                              </div>
                          </ul>
                      </div>
                  </div>
              </div>

              <!-- Bloc changement -->
              <div class="itineraire_flex_container_travel_details_walk" >
                  <div class="flex_container">
                      <i class="fas fa-walking fa-lg"></i><p> Changement</p>
                  </div>
              </div>

              <!-- Bloc trajet point A vers point B -->
              <div class="itineraire_flex_container_travel_details flex_container">
                  <div class="flex_container itineraire_flex_container_travel_details_container">
                      <div class="itineraire_flex_container_travel_details_hours">
                          <div class="itineraire_flex_container_travel_details_hours_start">
                              <p><?= $train_departure ?></p>
                          </div>
                          <div class="itineraire_flex_container_travel_details_end">
                              <p><?= $train_arrival ?></p>
                          </div>
                      </div>
                      <div class="itineraire_flex_container_travel_details_line">
                          <span class="dot dot_start_details"></span>
                          <svg height="170" width="30">
                              <g fill="none">
                                  <path stroke="red" d="M 0 0 L 0 200 " stroke-width="5" />
                              </g>
                          </svg>
                          <span class="dot dot_end_details"></span>
                      </div>
                      <div class="itineraire_flex_container_travel_details_box">
                          <div class="flex_container itineraire_flex_container_travel_details_start">
                              <p><b><?= $train_departure_city ?></b><?= ", " . $train_departure_platform ?></p>
                          </div>
                          <div class="flex_container itineraire_flex_container_travel_details_infos">
                              <div><i class="fas fa-train fa-lg"></i> <b><?= $train_number ?></b> Direction <b><?= $train_direction ?></b></div>
                              <div><p><b>42</b> min</p></div>
                          </div>
                          <div class="itineraire_flex_container_travel_details_end flex_container">
                              <p><b><?= $train_arrival_city ?></b><?= ", " . $train_arrival_platform ?></p>
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
                                  <i class="fas fa-long-arrow-alt-right animated fadeInLeft" style="display: none; padding-right: 5px"></i>
                              </div>
                              <div class="flex_container itineraire_flex_container_travel_action_outils_icon">
                                  <li> Afficher sur la carte</li>
                                  <i class="fas fa-map-marked-alt"></i>
                                  <i class="fas fa-long-arrow-alt-right animated fadeInLeft" style="display: none; padding-right: 5px"></i>
                              </div>
                              <div class="flex_container itineraire_flex_container_travel_action_outils_icon">
                                  <li> Ajouter au calendrier</li>
                                  <i class="fas fa-calendar-alt"></i>
                                  <i class="fas fa-long-arrow-alt-right animated fadeInLeft" style="display: none; padding-right: 5px"></i>
                              </div>
                          </ul>
                      </div>
                  </div>
              </div>

          </div>
        <?php
      }
      ?>

    </div>
  </div>
</div>
<script>
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
</script>

<style>

</style>
<?php
include("footer.html");
?>
