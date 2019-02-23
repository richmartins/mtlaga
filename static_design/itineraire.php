<?php
include("header.html");
?>
<div id="home_container">
  <div>
    <div class="flex_container" id="itineraire_flex_header_title" >
      <div id="itineraire_flex_Header_direction">
        <p>De <b>Lausanne</b> à <b>Genève</b></p>
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
      <div class="flex_container" id="itineraire_flex_container_title">
        <div id="itineraire_flex_container_title_now" class="itineraire_flex_container_center">
          <p><b>Maintenant</b></p>
        </div>
        <div id="itineraire_flex_container_title_time" class="itineraire_flex_container_center">
          <p><b>Durée</b></p>
        </div>
        <div id="itineraire_flex_container_title_change" class="itineraire_flex_container_center">
          <p><b>Changements</b></p>
        </div>
        <div id="itineraire_flex_container_title_more" class="itineraire_flex_container_center">
          <p><b>Action</b></p>
        </div>
      </div>
      <?php
      for($i = 0; $i < 15; $i++) {
        ?>
        <div class="itineraire_flex_container_travel_bck" id="<?= $i ?>">
          <div class="itineraire_flex_container_travel">
            <div class="itineraire_flex_container_travel_text">
              <p>IR 15 (Direction Lucerne) - Voie 1</p>
            </div>
            <div class="flex_container">
              <div class="flex_container itineraire_flex_container_travel_now">
                <div>
                  <p>07:00</p>
                </div>
                <div>
                  <span class="dot dot_start"></span>
                  <svg height="30" width="200">
                   <g fill="none">
                     <path stroke="red" d="M0 20 l200 0" stroke-width="3" />
                   </g>
                  </svg>
                  <span class="dot dot_end"></span>
                </div>
                <div>
                  <p>07:42</p>
                </div>
              </div>
              <div class="flex_container itineraire_flex_container_travel_time">
                <p>42min</p>
              </div>
              <div class="flex_container itineraire_flex_container_travel_change">
                <p>0 Changements</p>
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
                  <div class="itineraire_flex_container_travel_details_hours">
                      <div class="itineraire_flex_container_travel_details_start">
                          <p>07:00</p>
                      </div>
                      <div class="itineraire_flex_container_travel_details_end">
                          <p>07:42</p>
                      </div>
                  </div>
                  <div class="itineraire_flex_container_travel_details_line">
                      <span class="dot dot_start_details"></span>
                      <svg height="130" width="30">
                          <g fill="none">
                              <path stroke="red" d="M 0 0 L 0 140 " stroke-width="5" />
                          </g>
                      </svg>
                      <span class="dot dot_end_details"></span>
                  </div>
                  <div>
                      <div class="flex_container itineraire_flex_container_travel_details_start">
                          <p><b>Genève</b></p>
                      </div>
                      <div class="itineraire_flex_container_travel_details_end flex_container">
                          <p><b>Lausanne</b></p>
                      </div>
                  </div>
                  <div style="border: 2px solid green; width: 100%">
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
                  <div class="itineraire_flex_container_travel_details_hours">
                      <div class="itineraire_flex_container_travel_details_start">
                          <p>07:00</p>
                      </div>
                      <div class="itineraire_flex_container_travel_details_end">
                          <p>07:42</p>
                      </div>
                  </div>
                  <div class="itineraire_flex_container_travel_details_line">
                      <span class="dot dot_start_details"></span>
                      <svg height="130" width="30">
                          <g fill="none">
                              <path stroke="red" d="M 0 0 L 0 140 " stroke-width="5" />
                          </g>
                      </svg>
                      <span class="dot dot_end_details"></span>
                  </div>
                  <div>
                      <div class="flex_container itineraire_flex_container_travel_details_start">
                          <p><b>Genève</b></p>
                      </div>
                      <div class="itineraire_flex_container_travel_details_end flex_container">
                          <p><b>Lausanne</b></p>
                      </div>
                  </div>
                  <div style="border: 2px solid green; width: 100%">
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
                  <div class="itineraire_flex_container_travel_details_hours">
                      <div class="itineraire_flex_container_travel_details_start">
                          <p>07:00</p>
                      </div>
                      <div class="itineraire_flex_container_travel_details_end">
                          <p>07:42</p>
                      </div>
                  </div>
                  <div class="itineraire_flex_container_travel_details_line">
                      <span class="dot dot_start_details"></span>
                      <svg height="130" width="30">
                          <g fill="none">
                              <path stroke="red" d="M 0 0 L 0 140 " stroke-width="5" />
                          </g>
                      </svg>
                      <span class="dot dot_end_details"></span>
                  </div>
                  <div>
                      <div class="flex_container itineraire_flex_container_travel_details_start">
                          <p><b>Genève</b></p>
                      </div>
                      <div class="itineraire_flex_container_travel_details_end flex_container">
                          <p><b>Lausanne</b></p>
                      </div>
                  </div>
                  <div style="border: 2px solid green; width: 100%">
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
        $(this).toggleClass("down")  ;
    })
</script>

<style>

</style>
<?php
include("footer.html");
?>
