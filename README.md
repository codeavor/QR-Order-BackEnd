
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
    - [api/orders](#get-apiorders)
    - [api/menu/{item_id}](#get-apimenuitem_id)
    - [api/cart/{order_id}](#get-apicartorder_id)
- [POST](#post)
    - [api/orders](#post-apiorders)
    - [api/order_item](#post-apiorder_item)
    - [api/auth/login](#post-apiauthlogin)
    - [api/auth/register](#post-apiauthregister)
    - [api/auth/logout](#post-apiauthlogout)
    - [api/auth/refresh](#post-apiauthrefresh)
- [PUT](#put)
    - [api/cart/{order_id}](#put-apicartorder_id)
    - [api/orders/{order_id}](#put-apiordersorder_id)
    - [api/order_item/{order_item_id}](#put-apiorder_itemorder_item_id)
- [DELETE](#delete)
    - [api/order_item/{order_item_id}](#delete-apiorder_itemorder_item_id)
    - [api/orders/{order_id}](#delete-apiorders_{order_id})

___

### GET

#### GET api/menu
Used to get the menu.
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
                    "description",
                }
            ]
        }
    ]
}
````
[Back to top](#api-endpoints)

#### GET api/orders
Used to get all sent orders for kitchen.
````
Headers:
{
    'Authorization' : 'Bearer ' token
}

Response:
[
    {
        "cart": [
            {
                "id",
                "order_id",
                "item_id",
                "quantity",
                "notes",
                "item_name",
                "price",
                "description",
                "extras" => [
                     {
                        "id",
                        "name", 
                        "price",
                        "pivot" => {
                            "order_item_id",
                            "extra_id",
                        }
                    }
                ]
            }
        ],
        "order_complete": "sent",
        "updated_at": "date",
        "umbralla_id": "0","1"
    }
]
````

[Back to top](#api-endpoints)

#### GET api/menu/{item_id}
Get a specific item's info.
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
    "description",
    "extras" => 
    [
        {
            "id",
            "name",
            "price",
            "pivot" =>
            {
                "item_id",
                "extra_id,
            }
        }
    ]
}
````
[Back to top](#api-endpoints)

#### GET api/cart/{order_id}
Get the cart for the customer or take-away.
````
Headers:
{
    'Authorization' : 'Bearer ' token
}

Response:
[
    {
        "id",
        "order_id",
        "item_id",
        "quantity",
        "item_name",
        "price",
        "description",
        "notes",
        "extras" => [
         {
                "id",
                "name",
                "price",
                "pivot" => 
                {
                    "order_item_id",
                    "extra_id", 
                }
            },
        ]
    }
]
````
[Back to top](#api-endpoints)

___

### POST

#### POST api/orders
Create new order for kitchen.
````
Headers:
{
    'Authorization' : 'Bearer ' token
}

Body:
{
    "user_id": UserType id
}

Response:
{
    "order_id"
}
````
[Back to top](#api-endpoints)

#### POST api/order_item
Create new orderItem and add it to my cart.
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
    "notes",
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
    "notes",
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
Not used.
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
Used to connect with backend (get jwt).
````
Body:
{
    "umbrella_id"
}

Response:(for customer)
{
    "token",
    "orderId,
    "role_name",
}
Response:(for kitchen)
{
    "token",
    "role_name",
    "userTypeId"
}
````
[Back to top](#api-endpoints)

#### POST api/auth/logout
Used to logout.
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
Not used.
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
To mark an order as sent and delete user.
````
Headers:
{
    'Authorization' : 'Bearer ' token
}

Params:
{
    "order_complete": 'sent','unsent','completed','processed'
}

Response:
[
    {
        "cart": [
            {
                "id",
                "order_id",
                "item_id",
                "quantity",
                "notes",
                "item_name",
                "price",
                "description",
                "extras" => [
                     {
                        "id",
                        "name", 
                        "price",
                        "pivot" => {
                            "order_item_id",
                            "extra_id",
                        }
                    }
                ]
            }
        ],
        "order_complete": "sent",
        "updated_at": "date",
        "umbralla_id": "0","1"
    }
]
````
[Back to top](#api-endpoints)

#### PUT api/orders/{order_id}
To mark an order as sent, unsent, completed or processed for kitchen.
````
Headers:
{
    'Authorization' : 'Bearer ' token
}

Params:
{
    "order_complete": 'sent','unsent','completed','processed'
}

Response:
[
    {
        "cart": [
            {
                "id",
                "order_id",
                "item_id",
                "quantity",
                "notes",
                "item_name",
                "price",
                "description",
                "extras" => [
                     {
                        "id",
                        "name", 
                        "price",
                        "pivot" => {
                            "order_item_id",
                            "extra_id",
                        }
                    }
                ]
            }
        ],
        "order_complete": "sent",
        "updated_at": "date",
        "umbralla_id": "0","1"
    }
]
````
[Back to top](#api-endpoints)

#### PUT api/order_item/{order_item_id}
To change quantity of an order item.
````
Headers:
{
    'Authorization' : 'Bearer ' token
}

Params:
{
    "quantity": 2
}

Response:
[
    {
        "id",
        "order_id",
        "item_id",
        "quantity",
        "item_name",
        "price",
        "description",
        "notes",
        "extras" => [
         {
                "id",
                "name",
                "price",
                "pivot" => 
                {
                    "order_item_id",
                    "extra_id", 
                }
            },
        ]
    }
]
````
[Back to top](#api-endpoints)

___

### DELETE

#### DELETE api/order_item/{order_item_id}
To delete an orderItem.
````
Headers:
{
    'Authorization' : 'Bearer ' token
}

Response:
[
    {
        "id",
        "order_id",
        "item_id",
        "quantity",
        "item_name",
        "price",
        "description",
        "notes",
        "extras" => [
         {
                "id",
                "name",
                "price",
                "pivot" => 
                {
                    "order_item_id", 
                    "extra_id",
                }
            },
        ]
    }
]
````
[Back to top](#api-endpoints)

#### DELETE api/orders/{order_id}
To delete an order.
````
Headers:
{
    'Authorization' : 'Bearer ' token
}

Response:
[]
````
[Back to top](#api-endpoints)

___

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
