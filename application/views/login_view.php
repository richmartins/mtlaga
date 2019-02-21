<div class="form_style_bck" class="">
  <p>Connexion</p>
  <?php echo isset($error) ? $error : ''; ?>
  <form method="post" action="<?php echo site_url('Auth/process'); ?>">  
    <div class="form_style_front" >
      <div class="form_style_title">
        <p>Adresse mail</p>
        <input type="email" name="mail" value="" class="form_input">
      </div>
      <div class="form_style_title">
        <p>Mot de passe</p>
        <input type="password" name="password" value="" class="form_input">
      </div>
      <div class="form_style_submit form_style_title">
        <input type="submit" name="" value="Se connecter" class="form_input">
      </div>
      <div class="flex_container">
        <div class="form_style_link">
          <p><a href="#">Mot de passe oublié ?</a></p>
        </div>
        <div class="form_style_link">
          <p><a href="<?= base_url(); ?>auth/signup">S'inscrire sur MTLAGA ?</a></p>
        </div>
      </div>
    </div>
  </form>
</div>
