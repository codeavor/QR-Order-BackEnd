
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

## API Endpoints

- [GET](#get)
    - [api/menu](#get-apimenu)
    - [api/menu/{item_id}](#get-apimenuitem_id)
    - [api/cart/{order_id}](#get-apicartorder_id)
- [POST](#post)
    - [api/order_item](#post-apiorder_item)
    - [api/auth/login](#post-apiauthlogin)
    - [api/auth/register](#post-apiauthregister)
    - [api/auth/logout](#post-apiauthlogout)
    - [api/auth/refresh](#post-apiauthrefresh)
- [PUT](#put)
    - [api/cart/{order_id}](#put-apicartorder_id)
    - [api/order_item/{order_item_id}](#put-apiorder_itemorder_item_id)
- [DELETE](#delete)
    - [api/order_item/{order_item_id}](#delete-apiorder_itemorder_item_id)
    - [api/cart/{order_id}](#delete-apicartorder_id)

___

### GET

#### GET api/menu
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
[Back to top](#api-endpoints)

#### GET api/menu/{item_id}
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
[Back to top](#api-endpoints)

#### GET api/cart/{order_id}
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
[Back to top](#api-endpoints)

___

### POST

#### POST api/order_item
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
[Back to top](#api-endpoints)

#### POST api/auth/login
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
[Back to top](#api-endpoints)

#### POST api/auth/register
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
[Back to top](#api-endpoints)

#### POST api/auth/logout
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
[Back to top](#api-endpoints)

#### POST api/auth/refresh
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
[Back to top](#api-endpoints)

___

### PUT

#### PUT api/cart/{order_id}
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
[Back to top](#api-endpoints)

#### PUT api/order_item/{order_item_id}
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
[Back to top](#api-endpoints)

___

### DELETE

#### DELETE api/order_item/{order_item_id}
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
[Back to top](#api-endpoints)

___

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
