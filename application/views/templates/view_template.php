<?php
  defined('BASEPATH') OR exit('No direct script access allowed');
?>
<head>
  <title><?php echo $title; ?></title>
  <link rel = "stylesheet" type = "text/css" href = "<?php echo base_url(); ?>public/css/style.css">
</head>
<header>
  <div id="header_container">
  </div>
</header>

<div id="main-content">
  <?php
    echo 'id user : ' . $content['id_user'] . '<br />';
    echo 'email : ' . $content['email'] .'<br />';
    echo 'salt_password : ' . $content['salt_password'] .'<br />';
    echo 'admin status : ' . $content['admin'] .'<br />';
    echo 'user confirmend status : ' . $content['confirmed'] .'<br />';
  ?>
</div>
<footer>
  <div id="footer_container" class="flex_container">
    <div id="footer_text" class="flex_container">
      <div id="footer_text_owner">
        <p><b>MTLAGA</b></p>
        <p>Richard Martins & Hadrien Louis</p>
      </div>
      <div id="footer_text_contact">
        <p><b><a href="#">www.mtlaga.ch</a></b></p>
        <p><a href="">info@mtlaga.ch</a></p>
      </div>
    </div>
    <div id="footer_image">
       <img src="<?php echo base_url();?>public/pictures/logo/mtlaga_logo_ex2_withoutbg.png" alt="MTLAGA Logo">
    </div>
  </div>
  <div id="footer_copyright">
    <p>© 2019. Tous droits réservés. with ♥ by @richmartins | @hadrylouis</p>
  </div>
</footer>
