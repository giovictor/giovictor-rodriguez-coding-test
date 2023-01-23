<a name="readme-top"></a>

<div align="center">
    <h3 align="center">Backend Developer coding test</h3>
</div>

<!-- TABLE OF CONTENTS -->
<details>
  <summary>Table of Contents</summary>
  <ol>
    <li>
      <a href="#about-the-test">About the test</a>
    </li>
    <li>
      <a href="#requirements">Requirements</a>
      <ul>
        <li><a href="#product-specifications">Product specifications</a></li>
        <li><a href="#api-requirements">API Requirements</a></li>
      </ul>
    </li>
    <li>
      <a href="#getting-started">Getting started</a>
      <ul>
        <li><a href="#prerequisites">Prerequisites</a></li>
        <li><a href="#installation">Installation</a></li>
      </ul>
    </li>
    <li>
      <a href="#bonus-points">Bonus points</a>
    </li>
  </ol>
</details>

<!-- ABOUT THE TEST -->
## About the test

You're tasked to create a simple REST web service application for a fictional e-commerce business using Laravel.

You need to develop the following REST APIs:

* Products list
* Product detail
* Create product
* Update product
* Delete product

<!-- REQUIREMENTS -->
## Requirements

### Product specifications

A product needs to have the following information:

* Product name
* Product description
* Product price
* Created at
* Updated at

### API requirements

* Products list API
    * The products list API must be paginated.
* Create and Update product API
    * The product name, description, and price must be required.
    * The product name must accept a maximum of 255 characters.
    * The product price must be numeric in type and must accept up to two decimal places.
    * The created at and updated at fields must be in timestamp format.

Others:
* You are required to use MYSQL for the database storage in this test.
* You are free to use any library or component just as long as it can be installed using Composer.
* Don't forget to provide instructions on how to set the application up.

<p align="right">(<a href="#readme-top">back to top</a>)</p>

<!-- GETTING STARTED -->
## Getting Started

### Prerequisites

* Git
* Composer
* PHP ^8.0.2
* MySQL

### Installation

#### Automatically generate a new repository
Click <a href="https://github.com/QualityTrade/backend-dev-coding-test/generate" target="_blank">here</a> to generate a new repository from this template.

* Select your GitHub username as the owner.
* Name the repository `{FIRST NAME}-{LAST NAME}-coding-test`. (e.g. `john-doe-coding-test`)
* Make sure to set the repository visibility to Public.
* Clone your generated repository.

#### Manual
If automatically generating a new repository does not work, follow these steps instead.

* Click <a href="https://github.com/QualityTrade/backend-dev-coding-test/archive/refs/heads/main.zip">here</a> to download the ZIP archive of the test.
* Create a new repository named `{FIRST NAME}-{LAST NAME}-coding-test`. (e.g. `john-doe-coding-test`)
* Push your code to the new repository.

<p align="right">(<a href="#readme-top">back to top</a>)</p>

<!-- BONUS POINTS -->
## Bonus points

#### For bonus points:

* Cache the response of the Product detail API. You are free to use any cache driver.
* Use the Service layer and Repository design patterns.
* Create automated tests for the app.

#### Answer the question below by updating this file.

Q: The management requested a new feature where in the fictional e-commerce app must have a "featured products" section.
How would you go about implementing this feature in the backend?

A: 
 1. I will create a table named `featured_categories` to store and manage different featured categories to display in the featured products section. e.g. Best Seller, Top Rated, Newly Arrived, Limited Edition.
 2. I will create a table named `featured_categories_products` as a pivot table to handle identifier from `featured_caterogies` and `products` table to allow many to many relationship on what products belong to some featured categories.
 3. I will create an API endpoint to fetch all featured products and format their response by grouping them into each categories.

    `/api/featured`

    ```
    {
        "data": {
            "best_seller": [
                {
                    "name": 'Product A',
                    "price": 12.34
                },
                {
                    "name": 'Product B',
                    "price": 67.89
                }
                ...
            ],
            "top_rated": [
                {
                    "name": 'Product 1',
                    "price": 123.45
                },
                {
                    "name": 'Product 2',
                    "price": 678.90
                }
                ...
            ]
        }
    }
    ```
4. I will create another API endpoint to fetch a featured categories to get their products and show more details for each products listed.

    `/api/featured/{category}`

    ```
    {
        "data": [
            {
                "name": 'Product A',
                "price": 12.34,
                "description": 'Best product.',
                "stock": 100
            },
            {
                "name": 'Product B',
                "price": 67.89,
                "description": '2nd Best product.',
                "stock": 40
            }
            ... 
        ]
    }
    ```

## Coding Test Setup Instructions

1. Open a terminal and clone the repository

    ```
    git clone https://github.com/giovictor/giovictor-rodriguez-coding-test.git
    ```

2. Change to the directory of the repository
    ```
    cd giovictor-rodriguez-coding-test
    ```

3. Run `composer install` to generate a vendor folder
4. Copy the file `.env.example` and rename it `.env`
5. Run `php artisan key:generate`
6. Create a MySQL database named `giovictor-rodriguez-coding-test` or any db name you prefer
7. Update each of the following environment variables in the `.env` file required for the database connection:
    ```
    DB_HOST={MYSQL_HOST} # or default 127.0.0.1
    DB_PORT={MYSQL_PORT} # or default port
    DB_DATABASE=giovictor-rodriguez-coding-test # or another db name preferred
    DB_USERNAME={MYSQL_DATABASE_USERNAME}
    DB_PASSWORD={MYSQL_DATABASE_PASSWORD}
    ```

    Make sure the database was created or existing and the given credentials were correct in the `.env` file before proceeding with the next steps.

8. Back to the terminal, run `php artisan config:clear`
9. Run `php artisan migrate` to run migrations and create the products table in the database.
10. Run `php artisan db:seed` to populate test data in the products table (optional). You may also create your own data using the create endpoint `(POST) /api/products`. *(see Products Rest API Endpoints section below)*.

For feature tests, PHP extensions for `sqlite` must be enabled since it is being used for running tests.
* Run `php artisan test` or `php artisan test --filter ProductsTest` to make sure everything is working according to the written tests.

### Products Rest API Endpoints
1. `(GET) /api/products` - Fetch all products with a default pagination.

    Parameters: `page = 1, limit = 10`
    
    Response:

    Without parameters (default):
    ```
    {
        "page": "1",
        "limit": "10",
        "noOfPages": 10,
        "total": 100,
        "pageTotal": 10,
        "data": [
            {
                "id": 1,
                "name": "Exercitationem Sed Expedita",
                "description": "Et dolores impedit veniam accusamus.",
                "price": "7104.31",
                "created_at": "2023-01-22T07:09:49.000000Z",
                "updated_at": "2023-01-22T07:09:49.000000Z"
            },
            ...
        ]
    }
    ```

    With parameters:

    `(GET) /api/products?page=1&limit=5`

    ```
    {
        "page": "1",
        "limit": "5",
        "noOfPages": 20,
        "total": 100,
        "pageTotal": 5,
        "data": [
            {
                "id": 1,
                "name": "Exercitationem Sed Expedita",
                "description": "Et dolores impedit veniam accusamus.",
                "price": "7104.31",
                "created_at": "2023-01-22T07:09:49.000000Z",
                "updated_at": "2023-01-22T07:09:49.000000Z"
            },
            ...
        ]
    }
2. `(GET) /api/products/{id}` - Fetch a single product

    Parameters: `id`

    Response:
    ```
    {
        "data": {
            "id": 25,
            "name": "Et Odio Nobis",
            "description": "Blanditiis sint omnis qui voluptatem eaque non iusto aut.",
            "price": "4354.42",
            "created_at": "2023-01-22T07:09:50.000000Z",
            "updated_at": "2023-01-22T07:09:50.000000Z"
        }
    }
    ```

3. `(POST) /api/products` - Creates a product

    Request Data: `name, description, price`

    Response:
    ```
    {
        "message": "Product was created successfully.",
        "data": {
            "name": "Product ABC",
            "description": "Best product ever.",
            "price": 123.45,
            "updated_at": "2023-01-23T11:37:40.000000Z",
            "created_at": "2023-01-23T11:37:40.000000Z",
            "id": 105
        }
    }
    ```

4. `(PATCH) /api/products/{id}` - Update a product

    Request Data: `name, description, price`

    Parameters: `id`

    Response:
    ```
    {
        "message": "Product was updated successfully.",
        "data": {
            "id": 105,
            "name": "Product XYZ",
            "description": "The real best product ever.",
            "price": "678.90",
            "created_at": "2023-01-23T11:37:40.000000Z",
            "updated_at": "2023-01-23T11:37:55.000000Z"
        }
    }
    ```

5. `(DELETE) /api/products/{id}` - Delete a product

    Parameters: `id`

    Response:
    ```
    {
        "message": "Product was deleted successfully."
    }
    ```
