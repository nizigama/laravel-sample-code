# Shopping App

## Description

A minimalistic shopping app built with Laravel for showcasing basic Laravel skills

### Setup

Commands to run after cloning

-   Install composer dependencies
    ```
    docker run --rm -u "$(id -u):$(id -g)" -v $(pwd):/var/www/html -w /var/www/html laravelsail/php81-composer:latest composer install --ignore-platform-reqs
    ```
-   Build docker images and start servers
    ```
    ./vendor/bin/sail up
    ```
-   Migrate database tables and seed them
    ```
    ./vendor/bin/sail artisan migrate:fresh --seed
    ```

### Start

Command to start project

```
./vendor/bin/sail up
```
