# Getting Started

## Install PHP

To install PHP, go to https://www.php.net/downloads and install the latest stable version.

## Install composer

To install composer, go to https://getcomposer.org/download/ and follow the installation guide for your system.

## Install composer dependencies

After PHP and composer have been installed run ``composer install`` from the commandline. This command installs all
necessary dependencies.

## Configure database

To fully use the project you have to configure the database. For that consult the ``.env`` file in the root directory.
In there you have to customize the default configuration for the database connection to suite your system configuration.

This is the default configuration:

```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=homestead
DB_USERNAME=homestead
DB_PASSWORD=secret
```

I recommend using a mysql database and run it in a docker container.
Follow [this](https://phoenixnap.com/kb/mysql-docker-container) tutorial on how to set this up properly.

### Inspect database

To inspect the current data in the database I suggest to use [dbeaver](https://dbeaver.io/).

### migrate database

To generate the necessary database tables run ``php artisan migrate`` from the commandline.

## Run project

### start development server

To run the project on a development server run ``composer serve`` from the commandline.

### populate database

To fully use this project you want to generate dummy data in the database. For that
run ``php artisan migrate:fresh --seed`` from the commandline.
