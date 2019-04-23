<div class="auth_flex_container">
  <?php  if (null !== $this->session->flashdata('error')): ?>
      <p class="auth_error"><?= $this->session->flashdata('error') ?></p>
  <?php endif;?>
  <?php  if (null !== $this->session->flashdata('info')): ?>
      <p class="aut_info"><?= $this->session->flashdata('info') ?></p>
  <?php endif;?>
</div>
<div class="form_style_bck" >
  <p>S'inscrire</p>
  <form method="post" action="<?= site_url('auth/signup_process') ?>" >
    <div class="form_style_front" >
      <div class="form_style_title">
        <p>Adresse mail</p>
        <input type="email" name="mail" class="form_input">
      </div>
      <div class="form_style_title">
        <p>Mot de passe</p>
        <input type="password" name="password" class="form_input">
      </div>
      <div class="form_style_title">
        <p>Confirmer le mot de passe</p>
        <input type="password" name="password_confirm" class="form_input">
      </div>
      <div class="form_style_submit form_style_title">
        <input type="submit" value="S'inscrire" class="form_input">
      </div>
      <div class="form_style_link" id="signup_submit">
        <p><a href="<?= base_url(); ?>auth/login">Retour à la page de connexion ?</a></p>
      </div>
    </div>
  </form>
</div>
