<header>
  <div id="header_style">
    <div id="header_style_container" class="flex_container">
      <div id="header_style_logo" class="header_style_items">
        <img src="<?= base_url();?>public/img/mtlaga_logo_22.png" alt="MTLAGA Logo">
      </div>
      <div id="header_style_menu" class="flex_container">
        <div class="flex_container header_style_menu_items  header_style_menu_items_selected">
          <p><a href="home.php">Accueil</a></p>
        </div>
        <div class="flex_container header_style_menu_items ">
          <p><a href="info.php">Info</a></p>
        </div>
        <div class="flex_container header_style_menu_items ">
          <p><a href="#">Plans</a></p>
        </div>
      </div>
      <div id="header_style_actions" class="flex_container header_style_items">
        <div class="flex_container">
          <input id="header_style_menu_search" type="search" placeholder="Recherche">
        </div>
        <div id="header_style_menu_connexion" class="flex_container" >
          <img src="<?= base_url();?>public/img/mtlaga_user.png" alt="Connexion">
        </div>
      </div>
    </div>
    <?php if($connected) { ?>
      <div id="header_style_menu_connexion" class="flex_container" >
        <img src="<?= base_url();?>public/img/mtlaga_user.png" alt="Connexion">
      </div>
    </div>
  </div>
    <div id="header_style_menu_actions" >
      <div id="header_style_menu_actions_arrow"></div>
      <div id="header_style_menu_actions_rectangle">
        <div id="header_style_menu_action_rectangle_container">
          <div class="header_style_menu_action_rectangle_items flex_container">
            <div class="flex_container">
              <img src="<?= base_url();?>public/img/mtlaga_settings.png" alt="Settings img" class="header_style_menu_action_img">
            </div>
            <div class="flex_container">
              <p><a href="settings.php">Paramètres</a></p>
            </div>
          </div>
          <div class="header_style_menu_action_rectangle_items flex_container">
            <div class="flex_container">
              <img src="<?= base_url();?>public/img/mtlaga_logout.png" alt="Settings img" class="header_style_menu_action_img">
            </div>
            <div class="flex_container">
              <p><a href="#">Déconnexion</a></p>
            </div>
          </div>
        </div>
      </div>
    </div>
  <?php } else { ?>
      <a href="<?= base_url(); ?>login">
        <div id="header_style_menu_connexion" class="flex_container" >
          <img src="<?= base_url();?>public/img/mtlaga_user.png" alt="Connexion">
        </div>
      </a>
    </div>
  </div>
  <?php } ?>
  </div>
</header>
