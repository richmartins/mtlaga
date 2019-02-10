<?php
include("header.html");
?>
<div class="form_style_bck" >
    <p>Réglages</p>
    <div class="form_style_front" >
        <form action="" method="post">
            <div class="form_style_title">
                <p>Adresse mail</p>
                <input type="email" name="" value="" class="form_input" placeholder="hadry@protonmail.com" required>
            </div>
            <div class="form_style_submit form_style_title">
                <input type="submit" name="" value="Changer l'adresse mail" class="form_input">
            </div>
        </form>
        <form action="" method="post">
            <div class="form_style_title">
                <p>Nouveau mot de passe</p>
                <input type="password" name="" value="" class="form_input" required>
            </div>
            <div class="form_style_title">
                <p>Confirmer le nouveau mot de passe</p>
                <input type="password" name="" value="" class="form_input" required>
            </div>

            <div class="form_style_submit form_style_title">
                <input type="submit" name="" value="Changer le mot de passe" class="form_input">
            </div>
        </form>
    </div>
</div>
<?php
include("footer.html");
?>
