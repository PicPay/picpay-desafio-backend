PHPDocker.io generated environment
==================================

# Add to your project #

Simply, unzip the file into your project, this will create `docker-compose.yml` on the root of your project and a folder named `phpdocker` containing nginx and php-fpm config for it.

Ensure the webserver config on `docker\nginx.conf` is correct for your project. PHPDocker.io will have customised this file according to the application type you chose on the generator, for instance `web/app|app_dev.php` on a Symfony project, or `public/index.php` on generic apps.

Note: you may place the files elsewhere in your project. Make sure you modify the locations for the php-fpm dockerfile, the php.ini overrides and nginx config on `docker-compose.yml` if you do so.
 
# How to run #

Dependencies:

  * Docker engine v1.13 or higher. Your OS provided package might be a little old, if you encounter problems, do upgrade. See [https://docs.docker.com/engine/installation](https://docs.docker.com/engine/installation)
  * Docker compose v1.12 or higher. See [docs.docker.com/compose/install](https://docs.docker.com/compose/install/)

Once you're done, simply `cd` to your project and run `docker-compose up -d`. This will initialise and start all the containers, then leave them running in the background.

## Services exposed outside your environment ##

You can access your application via **`localhost`**, if you're running the containers directly, or through **``** when run on a vm. nginx and mailhog both respond to any hostname, in case you want to add your own hostname on your `/etc/hosts` 

Service|Address outside containers
------|---------|-----------
Webserver|[localhost:8080](http://localhost:8080)

## Hosts within your environment ##

You'll need to configure your application to use any services you enabled:

Service|Hostname|Port number
------|---------|-----------
php-fpm|php-fpm|9000
Memcached|memcached|11211 (default)

# Docker compose cheatsheet #

**Note:** you need to cd first to where your docker-compose.yml file lives.

  * Start containers in the background: `docker-compose up -d`
  * Start containers on the foreground: `docker-compose up`. You will see a stream of logs for every container running.
  * Stop containers: `docker-compose stop`
  * Kill containers: `docker-compose kill`
  * View container logs: `docker-compose logs`
  * Execute command inside of container: `docker-compose exec SERVICE_NAME COMMAND` where `COMMAND` is whatever you want to run. Examples:
        * Shell into the PHP container, `docker-compose exec php-fpm bash`
        * Run symfony console, `docker-compose exec php-fpm bin/console`
        * Open a mysql shell, `docker-compose exec mysql mysql -uroot -pCHOSEN_ROOT_PASSWORD`

# Recommendations #

It's hard to avoid file permission issues when fiddling about with containers due to the fact that, from your OS point of view, any files created within the container are owned by the process that runs the docker engine (this is usually root). Different OS will also have different problems, for instance you can run stuff in containers using `docker exec -it -u $(id -u):$(id -g) CONTAINER_NAME COMMAND` to force your current user ID into the process, but this will only work if your host OS is Linux, not mac. Follow a couple of simple rules and save yourself a world of hurt.

  * Run composer outside of the php container, as doing so would install all your dependencies owned by `root` within your vendor folder.
  * Run commands (ie Symfony's console, or Laravel's artisan) straight inside of your container. You can easily open a shell as described above and do your thing from there.
