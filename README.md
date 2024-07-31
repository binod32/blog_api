<p align="center">
  <a href="https://laravel.com" target="_blank">
    <img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo">
  </a>
</p>

<p align="center">
  <a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
  <a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
  <a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
  <a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## Laravel Blog API

This is a RESTful API for a blog application built with Laravel. It allows users to manage posts, categories, tags, and comments with role-based access control and token-based authentication.

## Features

-   User authentication using Laravel Sanctum
-   Role-based access control using Spatie Laravel-Permission
-   CRUD operations for users, posts, categories, tags, and comments
-   Middleware for role-based access control
-   Polymorphic relationships for comments and tags
-   Search and filter functionality for Posts using Laravel Query Builder
-   Eager loading for optimized database queries
-   Dynamic pagination

## Installation

1. Clone the repository:

    ```bash
    git clone git@github.com:binod32/blog_api.git
    ```

2. Navigate to the project directory:

    ```bash
    cd blog_api
    ```

3. Install dependencies:

    ```bash
    composer install
    ```

4. Generate an application key:

    ```bash
    php artisan key:generate
    ```

5. Run the database migrations and seed the database:

    ```bash
    php artisan migrate --seed
    ```

6. Start the development server:

    ```bash
    php artisan serve
    ```

## API Endpoints

### Authentication

-   **Register a new user**

    ```http
    POST /api/register
    ```

    Request body:

    ```json
    {
        "name": "Jane Doe",
        "email": "jane@example.com",
        "password": "password",
        "password_confirmation": "password"
    }
    ```

-   **Login**

    ```http
    POST /api/login
    ```

    Request body:

    ```json
    {
        "email": "jane@example.com",
        "password": "password"
    }
    ```

-   **Logout**

    ```http
    POST /api/logout
    ```

### User Management

-   **Get all users**

    ```http
    GET /api/users
    ```

-   **Get a single user**

    ```http
    GET /api/users/{user_id}
    ```

-   **Create a new user**

    ```http
    POST /api/users
    ```

    Request body:

    ```json
    {
        "name": "Jane Doe",
        "email": "jane@example.com",
        "password": "password"
    }
    ```

-   **Update a user**

    ```http
    PUT /api/users/{user_id}
    ```

    Request body:

    ```json
    {
        "name": "John Doe",
        "email": "john@example.com",
        "password": "newpassword"
    }
    ```

-   **Delete a user**

    ```http
    DELETE /api/users/{user_id}
    ```

### Post Management

-   **Get all posts**

    ```http
    GET /api/posts
    ```

-   **Get a single post**

    ```http
    GET /api/posts/{post_id}
    ```

-   **Create a new post**

    ```http
    POST /api/posts
    ```

    Request body:

    ```json
    {
        "title": "New Post",
        "body": "This is the body of the new post.",
        "author_id": 1,
        "category_id": 1,
        "tags": [1]
    }
    ```

-   **Update a post**

    ```http
    PUT /api/posts/{post_id}
    ```

    Request body:

    ```json
    {
        "title": "Updated Post",
        "body": "This is the updated body of the post.",
        "category_id": 2,
        "tags": [2]
    }
    ```

-   **Delete a post**

    ```http
    DELETE /api/posts/{post}
    ```

### Category Management

-   **Get all categories**

    ```http
    GET /api/categories
    ```

-   **Get a single category**

    ```http
    GET /api/categories/{category_id}
    ```

-   **Create a new category**

    ```http
    POST /api/categories
    ```

    Request body:

    ```json
    {
        "name": "Science"
    }
    ```

-   **Update a category**

    ```http
    PUT /api/categories/{category_id}
    ```

    Request body:

    ```json
    {
        "name": "Updated Category"
    }
    ```

-   **Delete a category**

    ```http
    DELETE /api/categories/{category}
    ```

### Tag Management

-   **Get all tags**

    ```http
    GET /api/tags
    ```

-   **Get a single tag**

    ```http
    GET /api/tags/{tag_id}
    ```

-   **Create a new tag**

    ```http
    POST /api/tags
    ```

    Request body:

    ```json
    {
        "name": "PHP"
    }
    ```

-   **Update a tag**

    ```http
    PUT /api/tags/{tag_id}
    ```

    Request body:

    ```json
    {
        "name": "Updated Tag"
    }
    ```

-   **Delete a tag**

    ```http
    DELETE /api/tags/{tag_id}
    ```

### Comment Management

-   **Get all comments**

    ```http
    GET /api/comments
    ```

-   **Get a single comment**

    ```http
    GET /api/comments/{comment_id}
    ```

-   **Create a new comment**

    ```http
    POST /api/comments
    ```

    Request body:

    ```json
    {
        "body": "This is a new comment.",
        "post_id": 1
    }
    ```

-   **Update a comment**

    ```http
    PUT /api/comments/{comment_id}
    ```

    Request body:

    ```json
    {
        "body": "This is an updated comment."
    }
    ```

-   **Delete a comment**

    ```http
    DELETE /api/comments/{comment_id}
    ```

## Role Management

The application uses Spatie's Laravel-Permission package to manage roles and permissions. By default, the following roles are included:

-   Admin
-   Author

The following permissions are included:

-   manage_users
-   manage_posts
-   manage_categories
-   manage_tags
-   manage_comments

## Middleware

Role-based access control is implemented using custom middleware. Only users with the appropriate permissions can create, update, or delete resources.

## Testing

Run the tests using PHPUnit:

```bash
php artisan test
```

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

```

```
