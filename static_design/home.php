<?php
include("header.html");
?>

<div id="home_container">
  <div id="home_style_flexbox" class="flex_container">

    <div class="flex_container home_style_flexbox_head" >
      <div class="flex_container home_style_flexbox_title_container" >
        <div class="flex_container home_style_flexbox_title_text" >
          <p>Horaires</p>
        </div>
        <div class="flex_container" >
          <img class="home_style_flexbox_title_img" src="img/mtlaga_home_clock.png" alt="">
        </div>
      </div>
        <form>
            <div id="home_style_flexbox_container" class="flex_container">
                <div class="flex_container" >
                    <input class="home_style_flexbox_fields" type="text" placeholder="Départ">
                </div>
                <div class="flex_container" >
                    <input class="home_style_flexbox_fields" type="text" placeholder="Arrivée">
                </div>
                <div class="flex_container form_style_submit" >
                    <input type="submit" class="home_style_flexbox_input" value="Rechercher" class="" type="text">
                </div>
            </div>
        </form>
    </div>

    <div class="flex_container home_style_flexbox_head" >
        <div class="flex_container home_style_flexbox_title_container" >
            <div class="flex_container home_style_flexbox_title_text" >
                <p>Trafic</p>
            </div>
            <div class="flex_container">
                <img class="home_style_flexbox_title_img" src="img/mtlaga_home_bell.png" alt="">
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
                <img class="home_style_flexbox_title_img" src="img/mtlaga_home_star.png" alt="">
            </div>
        </div>
        <div class="flex_container home_style_flexbox_sub_text">
            <p style="text-align: center">Pour afficher ce contenu, vous devez être connecté</p>
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

    // adaptation CSS image header quand scroll
    window.addEventListener( 'scroll', function( event ) {
        var lastScrollTop = 0;
        var element = document.getElementById("header_style_logo");
        var st = window.pageYOffset || document.documentElement.scrollTop;
        if (st > lastScrollTop){
            element.classList.add("header_style_logo_scroll")
        } else {
            element.classList.remove("header_style_logo_scroll")
        }
    }, false );

    var arrow = document.getElementById("header_style_menu_actions_arrow");
    var rectangle = document.getElementById("header_style_menu_actions_rectangle");

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


</script>

<?php
include("footer.html");
?>
