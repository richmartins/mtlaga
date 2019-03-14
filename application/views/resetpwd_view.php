<div class="form_style_bck" class="">
  <p>réinitialiser votre mot de passe</p>
  <?php echo isset($error) ? $error : ''; ?>
  <form method="get" action="<?php echo site_url('auth/reset_pwd_process'); ?>">
    <div class="form_style_front" >
      <div class="form_style_title">
        <p>Adresse mail</p>
        <input type="email" name="mail" class="form_input">
      </div>
      <div class="form_style_submit form_style_title">
        <input type="submit" name="" value="envoyer" class="form_input">
      </div>
    </div>
  </form>
</div>
