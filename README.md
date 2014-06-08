# Erpil

##Description

Erpil is a web application based on the [Laravel framework](http://github.com/laravel/framework).

It is lightly based in the [Simpledo UserManagement](https://github.com/XayOn/simpledo/tree/master/UserManagement) from [Simpledo](https://github.com/XayOn/simpledo) (Copyright © 2013 David Francos Cuartero <me@davidfrancos.net>) to be as compatible as possible with existing databases.

A migration task is provided to import existing databases into Erpil.

### Copyright

Copyright © 2014 Tnarik Innael.

### License

GPLv3 (`LICENSE.md`)


## Official Documentation

Documentation for the Laravel framework can be found on the [Laravel website](http://laravel.com/docs).



# Notes
- It uses Bootstrap 3.1.1 (21/05/2014)
- If classes are refactored, remember to execute `composer dump-autoload`
- Using rocketeer to deploy, accessible via `php artisan deploy:<xxx>`
- Uses `.env.<xxx>.php` configuration files to store IPs, users and such.

# Deployment (as manually executed in the test host machine)

The main thing is that we are copying all libraries, instead of recreating via `composer` or `npm`.

Move code to the production server:

- `scp` to the remote folder
- removed .git artefacts
- `apt-get install php5-mcrypt`
- `cd /var/www/app; chown -R www-data:www-data .`

Database configuration:

- Use production: for instance, by disabling the setting of $env in bootstrap/start.php, or by making it depend on an environment setting.
- `mysql -u root -proot -e "CREATE USER 'lcdv'@'localhost' IDENTIFIED BY 'lcdv_pass'"`
- `mysql -u root -proot -e "GRANT ALL PRIVILEGES ON lcdv.* TO lcdv@localhost IDENTIFIED BY 'lcdv_pass'"`
- `mysqladmin -u root -proot create lcdv`
- `php artisan migrate`
- Generate the migration from the SQL dump (either localy and copy, or remotely in the host).
- `php artisan db:seed --class=FacilitiesTableSeeder`
- `php artisan db:seed --class=ImportTableSeeder`

Apache configuration:

- `a2enmod rewrite`
- Configure `AllowOverride All` in the Apache settings for the Laravel project.

# Deployment (scripted by Rocketeer)
- [Composer](https://getcomposer.org/) should be installed in the machine:

	```
    php -r "readfile('https://getcomposer.org/installer');" | php
    mv composer.phar /usr/local/bin/composer
	```
- The required php modules should be installed in the machine:

    ```
    apt-get install php5-mcrypt php5-sqlite php5-mysql   
    ```
