<header>
  <div id="header_style">

      <!--  notif bar -->
      <div id="header_notif_load" class="header_notif animated fadeInDown">
          <div class="header_notif_spin">
              <i class="fas fa-spinner fa-pulse"></i>
          </div>
          <div class="header_notif_text">
              <p style="margin: 0">Recherche des relations en cours ...</p>
          </div>
      </div>
      <div id="header_notif_success" class="header_notif animated fadeInDown">
          <div class="header_notif_spin">
              <i class="fas fa-check"></i>
          </div>
          <div class="header_notif_text">
              <p style="margin: 0">Favoris supprimé</p>
          </div>
      </div>
      <div id="header_notif_error" class="header_notif animated fadeInDown">
          <div class="header_notif_spin">
              <i class="fas fa-times"></i>
          </div>
          <div class="header_notif_text">
              <p style="margin: 0">Erreur lors de la suppression</p>
          </div>
      </div>

      <!-- Nav Bar !-->
      <div id="header_style_container" class="flex_container">
          <div id="header_style_logo" class="header_style_items">
            <img src="<?= base_url(); ?>public/img/mtlaga_logo_22.png" alt="MTLAGA Logo">
          </div>
          <div id="header_style_menu" class="flex_container">
            <?php foreach ($header_nav_meta_data as $k => $v): ?>
                <?php if($v == $meta_data['active']): ?>
                    <div class="flex_container header_style_menu_items  header_style_menu_items_selected">
                        <p><a href="<?= base_url(); ?><?= $k; ?>"><?= $v; ?></a></p>
                    </div>
                <?php else: ?>
                    <div class="flex_container header_style_menu_items ">
                        <p><a href="<?= base_url(); ?><?= $k; ?>"><?= $v; ?></a></p>
                    </div>
                <?php endif; ?>
            <?php endforeach; ?>
          </div>

          <!-- Action Bar -->
          <div id="header_style_actions" class="flex_container header_style_items">
            <div class="flex_container">
              <input id="header_style_menu_search" type="search" placeholder="Recherche">
            </div>
             <?php
             if($meta_data['connected']) {
                 ?>
                 <div id="header_style_menu_connexion" class="flex_container" >
                     <img src="<?= base_url();?>public/img/mtlaga_user.png" alt="Connexion">
                 </div>
              <?php
             } else {
                 ?>
                 <div id="header_style_menu_connexion" class="flex_container" >
                     <a href="<?= base_url(); ?>auth/login"><img src="<?= base_url();?>public/img/mtlaga_user.png" alt="Connexion"></a>
                 </div>
              <?php
             }
             ?>
          </div>
      </div>

      <!-- Action  !-->
      <?php
      if($meta_data['connected']) {
          ?>
          <div id="header_style_menu_actions" >
              <div id="header_style_menu_actions_arrow"></div>
              <div id="header_style_menu_actions_rectangle">
                  <div id="header_style_menu_action_rectangle_container">
                      <div class="header_style_menu_action_rectangle_items flex_container">
                          <div class="flex_container">

                              <i class="fas fa-cog"></i>
                          </div>
                          <div class="flex_container">
                              <p><a href="#">Paramètres</a></p>
                          </div>
                      </div>
                      <div class="header_style_menu_action_rectangle_items flex_container">
                          <div class="flex_container">
                              <i class="fas fa-sign-out-alt"></i>
                          </div>
                          <div class="flex_container">
                              <p><a href="<?= base_url(); ?>auth/logoff">Déconnexion</a></p>
                          </div>
                      </div>
                  </div>
              </div>
          </div>
      <?php
      }
      ?>
  </div>
</header>


<script>
    // Handler when the DOM is fully loaded
    document.addEventListener("DOMContentLoaded", function(){

        // affichage menu utilisateur
        var arrow = document.getElementById("header_style_menu_actions_arrow");
        var rectangle = document.getElementById("header_style_menu_actions_rectangle");

        if(arrow != null) {
            arrow.style.display = "none";
            rectangle.style.display = "none";

            document.getElementById("header_style_menu_connexion").onclick = function() {
                if (arrow.style.display === "none") {
                    arrow.style.display = "block";
                    rectangle.style.display = "block";
                } else {
                    arrow.style.display = "none";
                    rectangle.style.display = "none";
                }
            };
        }
    });
</script>
