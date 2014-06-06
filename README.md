## Erpil

Erpil is based in the [Laravel framework](http://github.com/laravel/framework).


## Official Documentation

Documentation for the Laravel framework can be found on the [Laravel website](http://laravel.com/docs).



### License

TBD


# Notes
- It uses Bootstrap 3.1.1 (21/05/2014)
- If classes are refactored, remember to execute `composer dump-autoload`

# Deployment (as manually executed in the test host machine)

The main thing is that we are copying all libraries, instead of recreating via `composer` or `npm`.

Move code to the production server:

- `scp` to the remove folder
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