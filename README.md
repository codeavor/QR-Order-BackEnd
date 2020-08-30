# QR Order API

![Tests](https://github.com/codeavor/QR-Order-BackEnd/workflows/Test/badge.svg)
[![Maintainability](https://api.codeclimate.com/v1/badges/3814e1b051e12b356806/maintainability)](https://codeclimate.com/github/codeavor/QR-Order-BackEnd/maintainability)
[![Test Coverage](https://api.codeclimate.com/v1/badges/3814e1b051e12b356806/test_coverage)](https://codeclimate.com/github/codeavor/QR-Order-BackEnd/test_coverage)

## How to run:

-   Download or clone this repository
-   Put the folder in htdocs
-   Open terminal in project's folder
-   Run `composer install`
-   Run `copy .env.example .env` or `cp .env.example .env` (git bash)
-   Open .env file and change the database name (DB_DATABASE)
-   Run `php artisan key:generate`
-   Run `php artisan migrate`
-   Run `php artisan serve`

## How to use postgres database:

-   Install Postgres from [here](https://www.postgresql.org/download/)
-   Search for `;extension=pdo_pgsql` and `;extension=pgsql` inside php.ini file located in xampp's folder and remove the `;`
-   In .env file change DB_CONNECTION, DB_PORT, DB_DATABASE, DB_USERNAME and DB_PASSWORD matching postgres' defaults
-   In xampp start only the Apache Module
-   Create your migration files as usual and run migration


## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
