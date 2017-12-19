# PersonalizedTravelMonitor

## Laradock

### Development setup

* `git clone https://github.com/laradock/laradock`
* `cd laradock`
* Copy the file `nginx/sites/app.conf.example` to `nginx/sites/ptm.conf`
	* Change `app.test` to `ptm.test`
	* Change `/var/www/app` to `/var/www/ptm`
* `cd ..`
	* You should now be in the folder that contains the `laradock` folder
* `git clone https://github.com/PersonalizedTravelMonitor/Application ptm`
*	`cd ptm`
* Copy the file `.env.example` to `.env`
	* Change `DB_HOST` to `mysql`
	* Change `DB_DATABASE` to `PTM`
	* Change `DB_USERNAME` to `root`
	* Change `DB_PASSWORD` to `root`
* `cd ..; cd laradock`
* `docker-compose up -d nginx mysql phpmyadmin`
	* Wait for everythin to load
* `docker exec -ti laradock_mysql_1 bash`
	* `mysql -u root -proot` (no space)
	* `CREATE DATABASE PTM;`
* `docker exec -ti --user=laradock laradock_workspace_1 bash`
	* `cd ptm`
	* `composer install`
	* `php artisan key:generate`
	* `php artisan migrate`
* Edit `/etc/hosts` (or the Windows equivalent), need sudo
	* Add `127.0.0.1 ptm.test`
* Connect to [the site](http://ptm.test)

### Starting/stopping the website for development

* `docker-compose up -d nginx mysql phpmyadmin`
	* This will start the services
	* `docker ps` to make sure they are running
* `docker-compose down`
	* This will stop the services

## Laravel

### Useful commands

Make sure you are inside the `laradock_workspace` container (`docker exec -ti --user=laradock laradock_workspace_1 bash`) and inside the project folder

* `php artisan migrate`: run migrations (database schema updates)
* `php artisan migrate:reset`: rollback
* `php artisan migrate:refresh`: rollback+migrate

* `php artisan make:migration migration_description --create=tableName`
	* Example: `php artisan make:migration add_votes_to_users_table --create=users`

* `php artisan make:model ModelName -m`: create model and its migration
