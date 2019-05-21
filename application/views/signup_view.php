<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<style>
captchaimage {
  margin-bottom: 7px;
  width: 100%;
  height: 100%;
  border-radius: 10px;
}


.flex-container{
    display:flex;
    border: 2px solid red;
    width:40%;
}

.flex-container2{
    display:flex;
    border: 2px solid yellow;
    width:60%;
}

.flex-container3{
  display: flex;
  border: 2px solid yellow;
  width: 90%;
  margin-left: 3%;

}


.flex-container4{
  margin-top: 13%;
  height: 20%;
  display: flex;
  margin-left: 3%;
  border: 2px solid green;


}

.flex-container-master{
    display:flex;
    border: 2px solid blue;
    height: 100px;
    width:100%;

}

.form_input_Cap {
  width: 100%;
  background-color: #EBEBEB;
  height: 30px;
  border: none;
  outline: none;
  font-size: 18px;
  padding: 5px;
  margin-top: 50%;
  margin-botom:50%;
}


.item {
  flex-basis: <length> | auto; /* default auto */
}

</style>

<div class="auth_flex_container">
  <div class="auth_signup_<?=$this->session->flashdata('class');?>">
    <?php  if (null !== $this->session->flashdata('error')): ?>
      <p><?= $this->session->flashdata('error') ?></p>
    <?php endif;?>
    <?php  if (null !== $this->session->flashdata('info')): ?>
      <p><?= $this->session->flashdata('info') ?></p>
    <?php endif;?>
  </div>
</div>
<div class="form_style_bck" >
  <p>S'inscrire</p>
  <form method="post" action="<?= site_url('auth/signup_process') ?>" >
    <div class="form_style_front" >
      <div class="form_style_title">
        <p>Adresse mail</p>
        <input type="email" name="mail" class="form_input" required>
      </div>
      <div class="form_style_title">
        <p>Mot de passe</p>
        <input id="password_input" type="password" name="password" class="form_input" required>
        <div class="form_style_signup_password_strengh">
          <meter id="password-meter" low="4" high="4" min="0" max="10" value="0"></meter>
          <label class='stat_pass'> </label>
        </div>
      </div>
      <div class="form_style_title">
        <p>Confirmer le mot de passe</p>
        <input type="password" name="password_confirm" class="form_input" required>
      </div>
      <div class="form_style_submit form_style_title">
        <input id="form_signup_submit" type="submit" value="S'inscrire" class="form_input">
      </div>
      <!--Div principal contenant les flex-box-->
      <div class="div_captcha flex-container-master">
          <div class="flex-container">
              <input class="form_input_Cap" type="text" id="captcha" name="captcha" >
          </div>
          <div class="flex-container2">
            <div class="flex-container3">
              <!--Ajout de l'image Captcha-->
              <img src="data:image/png;base64,<?= captcha(); ?>" alt="captcha">
            </div>
            <div class="flex-container4">
              <i class="fas fa-sync-alt refresh-captcha rotate captcha-image "></i>
            </div>
          </div>
      </div>
      <div class="form_style_link" id="signup_submit">
        <p><a href="<?= base_url(); ?>auth/login">Retour à la page de connexion ?</a></p>
      </div>
    </div>
  </form>
</div>
<script>
  var refreshButton = document.querySelector(".refresh-captcha");
  refreshButton.onclick = function(){
    document.querySelector(".captcha-image").src = 'captcha.php?' + Date.now();
  }
  
  $(document).ready(function() {

    var strong = new RegExp("^(?=.*[A-Za-z])(?=.*[0-9])(?=.*[$@$!%*#?&])[A-Za-z0-9$@$!%*#?&]{8,}");
    var medium = new RegExp('^(?=.*[A-Za-z])(?=.*[0-9])[A-Za-z0-9]{8,}');
    var ok = new RegExp("^.{8}");
    var low = new RegExp("^.{2}");

    $('#password_input').keyup(function() {
      var value = $(this).val();
      switch (true) {
        case strong.test(value):
          $('#password-meter').show();
          $('#password-meter').val('10');
          $('.stat_pass').empty();
          $('.stat_pass').append('Mot de passe fort');
          break;
        case medium.test(value):
          $('#password-meter').show();
          $('#password-meter').val('7');
          $('.stat_pass').empty();
          $('.stat_pass').append('Mot de passe moyen');
          break;
        case ok.test(value):
          $('#password-meter').show();
          $('#password-meter').val('4');
          $('.stat_pass').empty();
          $('.stat_pass').append('Mot de passe bon');
          break;
        case low.test(value):
          $('#password-meter').show();
          $('#password-meter').val('1.5');
          $('.stat_pass').empty();
          $('.stat_pass').append('Mot de passe très faible');
          break;
        case value = '':
          $('#password-meter').hide();
          $('#password-meter').val('0');
          $('.stat_pass').empty();
          break;
        default:
          $('#password-meter').hide();
          $('#password-meter').val('0');
          $('.stat_pass').empty();
      }
    })
  });
 </script>
