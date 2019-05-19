<?php
if (! defined('BASEPATH')) exit('No direct script access allowed');

if (! function_exists('captcha_helper')) {
    function captcha_helper()
    {
        // get main CodeIgniter object
        $ci = get_instance();

        // Write your logic as per requirement
        //Caractère permis
        $permitted_chars = 'ABCDEFGHJKLMNPQRSTUVWXYZ012345689';

        //génération du la suite de caractères
        function generate_string($input, $strength = 10) {

            //Longueur de la suite
            $input_length = strlen($input);
            $random_string = 0;
            //Boucle des caratères
            for($i = 0; $i < $strength; $i++) {
                $random_character = $input[mt_rand(0, $input_length - 1)];
                $random_string .= $random_character;
            }

            //Retourne la valeur
            return $random_string;
        }

        $image = imagecreatetruecolor(200, 50);

        imageantialias($image, true);

        //Variable de couleur
        $colors = [];
        //Liste couleur aléatoire
        $red = rand(125, 170);
        $green = rand(125, 175);
        $blue = rand(125, 180);

        //
        for($i = 0; $i < 5; $i++)
        {
          //Contaste trame de fond
          $colors[] = imagecolorallocate($image, $red - 25*$i, $green - 25*$i, $blue - 25*$i);
        }

        //Couleur du fond BG
        imagefill($image, 100, 0, $colors[0]);

        for($i = 0; $i < 10; $i++)
        {
          //largeur des traits aléatoire
          imagesetthickness($image, rand(2, 10));
          //Couleur des traits
          $line_color = $colors[rand(1, 4)];
          imagerectangle($image, rand(-10, 190), rand(-10, 10), rand(-10, 190), rand(40, 60), $line_color);
        }

        //Couleur du texte
        $black = imagecolorallocate($image, 0, 0, 0);
        $white = imagecolorallocate($image, 255, 255, 255);
        $textcolors = [$black, $white];

        //Police d'écriture
        $fonts = [dirname(__FILE__).'/font/VEnigma45.ttf'];

        //Longueur de la chaine caractère
        $string_length = "4";
        $captcha_string = generate_string($permitted_chars, $string_length);

        $_SESSION['captcha_text'] = $captcha_string;

        for($i = 0; $i < $string_length; $i++) {
         $letter_space = 170/$string_length;
         $initial = 15;
         imagettftext($image, 24, rand(-15, 15), $initial + $i*$letter_space, rand(25, 45), $textcolors[rand(0, 1)], $fonts[array_rand($fonts)], $captcha_string[$i]);
        }

        header('Content-type: image/png');
        imagepng($image);
        imagedestroy($image);
        ?>

        <script>
          var refreshButton = document.querySelector(".refresh-captcha");
          refreshButton.onclick = function()
          {
            document.querySelector(".captcha-image").src = 'captcha.php?' + Date.now();
          }
        </script>
    }
}
