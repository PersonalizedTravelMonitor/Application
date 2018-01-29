# PersonalizedTravelMonitor

## Laradock

### Development setup

* `git clone https://github.com/laradock/laradock`
* `cd laradock`
* Copy the file `nginx/sites/app.conf.example` to `nginx/sites/ptm.conf`
	* Change `app.test` to `ptm.test`
	* Change `/var/www/app` to `/var/www/ptm/public`
* `cd ..`
	* You should now be in the folder that contains the `laradock` folder
* `git clone https://github.com/PersonalizedTravelMonitor/Application ptm`
*	`cd ptm`
* `git config user.name "YOUR NAME"`
* `git config user.email "YOUR UNIVERSITY EMAIL"`
* Copy the file `.env.example` to `.env`
	* Change `DB_HOST` to `mysql`
	* Change `DB_DATABASE` to `PTM`
	* Change `DB_USERNAME` to `root`
	* Change `DB_PASSWORD` to `root`
* `cd ..; cd laradock`
* Copy the file `env-example` to `.env`
* `docker-compose up -d nginx mysql phpmyadmin`
	* Wait for everythin to load
* `docker exec -ti laradock_mysql_1 bash`
	* `mysql -u root -proot` (no space)
	* `CREATE DATABASE PTM;`
* `docker exec -ti --user=laradock laradock_workspace_1 bash`
	* `cd ptm`
	* `composer install`
	* `php artisan key:generate`
	* `php artisan migrate --seed`
* Edit `/etc/hosts` (or the Windows equivalent), need sudo
	* Add `127.0.0.1 ptm.test`
* Connect to [the site](http://ptm.test)
* Install the [EditorConfig plugin](http://editorconfig.org/#download) for your text editor (Sublime Text 3 or Visual Studio Code recommended)

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
	* Example: `php artisan make:migration add_votes_to_users_table --table=users`

* `php artisan make:model ModelName -m`: create model and its migration

## Advanced things

### Social login

* Edit `laradock/nginx/sites/ptm.con`
	* Add `ptm.test.com` next to to `ptm.test` on the listening domains
* Edit `/etc/hosts` (or the Windows equivalent), need sudo
	* Add `127.0.0.1 ptm.test.com`
* Get the `CLIENT_ID` and `CLIENT_SECRET` tokens from the provider website
* Add them to `.env` file inside `ptm/`.
	* Use the format `$PROVIDER_CLIENT_ID` and `$PROVIDER_CLIENT_SECRET`
	* For example `TWITTER_CLIENT_ID` and `TWITTER_CLIENT_SECRET`
* Add the social provider inside `ptm/config/services` similarly to the one already present
* Create a link for sign in via the blade directive `{{ route('social.login', '$providerName') }}` in the login/register view

## Push notifications (required for development)

* `cd /laradock`
* `docker-compose down`
* `cp ../ptm/.patches/enable-php-gmp.patch .`
* `git apply enable-php-gmp.patch`
	* If it is not working:
		* In `laradock/php-fpm/Dockerfile-71`
			* Add `RUN apt-get update && apt-get -y install libgmp-dev && docker-php-ext-install gmp`
			* At the bottom, before (prima) `# Final Touch`
			* If you don't find it, search for it
		* In `laradock/workspace/Dockerfile-71`
			* Add `RUN apt-get update && apt-get -y install php7.1-gmp`
			* At the bottom, before (prima) `# Final Touch`
			* If you don't find it, search for it
* `docker-compose build php-fpm workspace`
* `docker-compose up nginx mysql`
* `docker exec -ti --user=laradock laradock_workspace_1 bash`
	* `cd ptm`
	* `composer install`
	* Check if everything works!
	* `php artisan migrate`
	* `php artisan webpush:vapid`
* You need HTTPS, this will work only on production

## Troubleshooting

* `Class not found` error / an error after `git pull`
	* `composer dump-autoload`
	* Re-run the command

