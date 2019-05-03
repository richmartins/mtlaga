<div class="auth_flex_container">
  <?php  if (null !== $this->session->flashdata('error')): ?>
      <p class="auth_error"><?= $this->session->flashdata('error') ?></p>
  <?php endif;?>
  <?php  if (null !== $this->session->flashdata('info')): ?>
      <p class="auth_info"><?= $this->session->flashdata('info') ?></p>
  <?php endif;?>
  <?php if (null !== $this->session->flashdata('email')): ?>
      <p class="auth_info">Un courreil à été envoyer sur votre adresse mail. Si vous ne l'avez pas reçu, vous pouvez cliquer sur : <a href="<?= base_url(); ?>auth/resend_confirm/?email=<?= $this->session->flashdata('email'); ?>">renvoyer</a>
  <?php endif; ?>
</div>
<div class="form_style_bck">
  <p>Connexion</p>
  <form method="post" action="<?php echo site_url('auth/login_process'); ?>">
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
          <p><a href="<?= base_url();?>auth/reset">Mot de passe oublié ?</a></p>
        </div>
        <div class="form_style_link">
          <p><a href="<?= base_url(); ?>auth/signup">S'inscrire sur MTLAGA ?</a></p>
        </div>
      </div>
    </div>
  </form>
</div>
