<div class="form_style_bck" class="">
  <p>réinitialiser votre mot de passe</p>
  <form method="post" action="<?php echo site_url('auth/change_db_pwd'); ?>">
    <div class="form_style_front" >
      <div class="form_style_title">
        <p>Nouveau mot de passe</p>
        <input type="text" name="password" class="form_input">
        <p>Confirmer votre mot de passe</p>
        <input type="text" name="password_confirm" class="form_input">
      </div>
      <div class="form_style_submit form_style_title">
        <input type="submit" name="" value="envoyer" class="form_input">
      </div>
    </div>
    <input type="hidden" name="email" value="<?= $this->session->flashdata('email'); ?>"/>
    <input type="hidden" name="token" value="<?= $this->session->flashdata('token'); ?>"/>
  </form>
</div>
