# MTLAGA
Is a web application for consulting schedule of trains and buses in switzerland

# Installation
we are using **mod_rewrite** from apache in order to have a beautiful **url**.

to install it on ubuntu, you must first

**1.**  enable rewrite module

    sudo a2enmod rewrite

**2.** then if it is the first time that you enable it. You will have to edit your **site.conf** file.

    sudo nano /etc/apache2/sites-available/000-default.conf

and add the fellowing lines in it


```apacheconf

<VirtualHost *:80>
<Directory /var/www/html>
    Options Indexes FollowSymLinks MultiViews
    AllowOverride All
    Require all granted
</Directory>
[...]
</VirtualHost>

```

**3.** finally you will have to restart you server.

    sudo systemctl restart apache2

**4.** Install composer && depths

    curl -s https://getcomposer.org/installer | php
  
    sudo mv composer.phar /usr/local/bin/composer

    composer -v

    composer install

more details will be coming soon
