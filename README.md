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

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
