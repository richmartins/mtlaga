<?php
include("header.html");
?>
<div id="home_container">
  <div>
    <div class="flex_container" id="itineraire_flex_header_title" >
      <div id="itineraire_flex_Header_direction">
        De <b>Lausanne</b> à <b>Genève</b>
      </div>
      <div class="flex_container" id="itineraire_flex_header_time">
        <div><p>15:56 | 02.02.2019</p></div>
        <div><img src="./img/mtlaga_calendar.png" alt="calendar"></div>
      </div>
    </div>
  </div>
  <div id="itineraire_flex_container_bck" >
    <div id="itineraire_flex_container">
      <div class="flex_container" id="itineraire_flex_container_title">
        <div id="itineraire_flex_container_title_now">
          <span>Maintenant</span>
        </div>
        <div id="itineraire_flex_container_title_time">
          <p>Durée</p>
        </div>
        <div id="itineraire_flex_container_title_change">
          <p>Changements</p>
        </div>
        <div id="itineraire_flex_container_title_more">
          <p>Action</p>
        </div>
      </div>
      <?php
      $travels = 10;
      for($i = 0; $i < 10; $i++) {
        ?>
        <div class="itineraire_flex_container_travel_bck" id="<?= $i ?>">
          <div class="itineraire_flex_container_travel">
            <div class="itineraire_flex_container_travel_text">
              <p>IR 15 (Direction Lucerne) - Voie 1</p>
            </div>
            <div class="flex_container">
              <div class="flex_container itineraire_flex_container_travel_now">
                <div>
                  <p style="margin: 0;">07:00</p>
                </div>
                <div>
                  <span class="dot"></span>
                  <svg height="30" width="200" style="position: relative; bottom: 8px;">
                   <g fill="none">
                     <path stroke="red" d="M0 20 l200 0" stroke-width="3" />
                   </g>
                  </svg>
                  <span class="dot2"></span>
                </div>
                <div>
                  <p style="margin: 0;">07:42</p>
                </div>
              </div>
              <div class="flex_container itineraire_flex_container_travel_time">
                <p>42min</p>
              </div>
              <div class="flex_container itineraire_flex_container_travel_change">
                <p>0 Changements</p>
              </div>
              <div class="flex_container itineraire_flex_container_travel_more">
                <p>+</p>
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
<script type="text/javascript">
$(document).on("click",".itineraire_flex_container_travel_bck", function () {
   var clickedBtnID = $(this).attr('id'); // or var clickedBtnID = this.id
   alert('you clicked on button #' + clickedBtnID);
});
</script>
<?php
include("footer.html");
?>
