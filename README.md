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

## Endpoints

-   GET:
    -   api/menu
        ````
        Headers:
        {
            'Authorization' : 'Bearer ' token
        }
        
        Response:
        {
            [
                {
                    "id",
                    "name",
                    "description",
                    "items" => 
                    [
                        {
                            "id",
                            "name",
                            "price",
                            "category_id"
                        }
                    ]
                }
            ]
        }
        ````
    -   api/menu/{item_id}
        ````
        Headers:
        {
            'Authorization' : 'Bearer ' token
        }
        
        Response:
        {
            "id",
            "name",
            "price",
            "category_id",
            "extras" => 
            [
                {
                    "id",
                    "name",
                    "price",
                    "pivot" =>
                    {
                        "item_id",
                        "extra_id
                    }
                }
            ]
        }
        ````
    -   api/cart/{order_id}
        ````
        Headers:
        {
            'Authorization' : 'Bearer ' token
        }
        
        Response:
        [
            {
                "order_item_id",
                "quantity",
                "extras",
                "extras_price",
                "name",
                "price"
            }
        ]
        ````
-   POST:
    -   api/order_item
        ````
        Headers:
        {
            'Authorization' : 'Bearer ' token
        }
        
        Body:
        {
            "order_id",
            "item_id",
            "quantity",
            "extras_id": [
                {
                    "extra_id",
                }
            ]
        }
        
        Response:
        {
            "id",
            "order_id",
            "item_id",
            "quantity",
            "extras" => 
            [
                {
                    "id",
                    "name",
                    "price",
                    "pivot" =>
                    {
                        "item_id",
                        "extra_id
                    }
                }
            ]
        }
        ````
    -   api/auth/login
        ````
        Body:
        {
            "id (του userType)"
        }
        
        Response:
        {
            "token"
        }
        ````
    -   api/auth/register
        ````
        Body:
        {
            "role_name",
            "umbrella_id"
        }
        
        Response:
        {
            "token",
            "orderId
        }
        ````
    -   api/auth/logout
        ````
        Headers:
        {
            'Authorization' : 'Bearer ' token
        }
        
        Response:
        {
            "message"
        }
        ````
    -   api/auth/refresh
        ````
        Headers:
        {
            'Authorization' : 'Bearer ' token
        }
        
        Response:
        {
            "refreshedToken"
        }
        ````
-   PUT:
    -   api/cart/{order_id}
        ````
        Headers:
        {
            'Authorization' : 'Bearer ' token
        }
        
        Params:
        {
            "ο,τι πρεπει να αλλαξεις"
        }
        
        Response:
        {
            "id",
            "umbrella_id",
            "created_at",
            "updated_at",
            "order_complete",
            "user_type_id"
        }
        ````
    -   api/order_item/{order_item_id}
        ````
        Headers:
        {
            'Authorization' : 'Bearer ' token
        }
        
        Params:
        {
            "ο,τι πρεπει να αλλαξεις"
        }
        
        Response:
        {
            "order_item_id",
            "quantity",
            "extras",
            "extras_price",
            "name",
            "price"
        }
        ````
-   DELETE:
    -   api/order_item/{order_item_id}
        ````
        Headers:
        {
            'Authorization' : 'Bearer ' token
        }
        
        Response:
        {
            "order_item_id",
            "quantity",
            "extras",
            "extras_price",
            "name",
            "price"
        }
        ````
## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
