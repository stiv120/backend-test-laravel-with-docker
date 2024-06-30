<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework.

You may also try the [Laravel Bootcamp](https://bootcamp.laravel.com), where you will be guided through building a modern Laravel application from scratch.

If you don't feel like reading, [Laracasts](https://laracasts.com) can help. Laracasts contains thousands of video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

## Laravel Sponsors

We would like to extend our thanks to the following sponsors for funding Laravel development. If you are interested in becoming a sponsor, please visit the [Laravel Partners program](https://partners.laravel.com).

### Premium Partners

- **[Vehikl](https://vehikl.com/)**
- **[Tighten Co.](https://tighten.co)**
- **[WebReinvent](https://webreinvent.com/)**
- **[Kirschbaum Development Group](https://kirschbaumdevelopment.com)**
- **[64 Robots](https://64robots.com)**
- **[Curotec](https://www.curotec.com/services/technologies/laravel/)**
- **[Cyber-Duck](https://cyber-duck.co.uk)**
- **[DevSquad](https://devsquad.com/hire-laravel-developers)**
- **[Jump24](https://jump24.co.uk)**
- **[Redberry](https://redberry.international/laravel/)**
- **[Active Logic](https://activelogic.com)**
- **[byte5](https://byte5.de)**
- **[OP.GG](https://op.gg)**

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

## About this project

The following project is a system that has a basic API for managing tasks.
The project consists of three main components:

1. Task Management API
    -Provides CRUD (Create, Read, Update, Delete) operations for tasks
    -Includes a Task model with fields such as title, description, status, and due date
    -Follows Laravel's routing conventions for the CRUD routes
    -Utilizes Laravel's validation system through the TaskRequest class
    -Handles errors by returning appropriate JSON responses
    -Follows Laravel's best practices in structuring the controller, separating logic into specific    methods
2. JWT Authentication
    -Implements JWT (JSON Web Token) authentication
    -Provides routes for user registration and login
    -Protects the task CRUD routes with an authentication middleware
    -Uses the tymon/jwt-auth library for JWT implementation
    -Follows Laravel's best practices in structuring the authentication controller
3. Advanced Filtering and Testing
    -Allows filtering tasks by status and due date
    -Includes unit tests for the task CRUD routes, covering success and error cases
    -Implements the filtering functionality in the index() method of the controller
    -Uses Laravel's unit testing system to validate the behavior of the API
    -The project aims to demonstrate the developer's skills in using Laravel to build a secure and   testable API, following best practices and guidelines.

## Installation

Note: Since our application has been integrated with Docker, we must have Docker Desktop installed on our machine, if you don't have it, here's the download link: https://www.docker.com/products/docker-desktop/ for our application and the commands given below to work.

1. We clone the repository:
```sh
git clone https://github.com/stiv120/test-backend
```
2. We access the directory in the path where we downloaded it:
```sh
cd test-backend
```
3. we install the Laravel dependencies, we access our container using the following command:
```sh
docker exec -it app bash
```
4. Then using the following command
```sh
composer install
```
5. We run the migrations using the following command:
```sh
php artisan migrate
```

## Start the application

we execute the following command:
```sh
docker compose up -d
```
This will bring up the container, with all the services we need to run our application, including the server through which we will access it through this link: http://localhost:8990 to view the application.

## Accessing the APIs

Note: In my case, I used Postman to test the APIs. If you don't have it installed, here's the link:
https://www.postman.com/downloads/

1. User Registration: We enter the required data for user registration (name, email, and password).
Access route: http://localhost:8990/register method GET

2. Login: If the user was created successfully, we enter the access credentials.
Access route: http://localhost:8990/login method GET

Note: When we log in, it will return the access token (access_token), which we will need to add to the header of each task request, as we have implemented the JWT authentication system and the task routes are protected by middleware that verifies if the user is authenticated and if the token is valid, in addition to other validations.
The configuration would be as follows:
```sh
key: Authorization
value: Bearer token
```
We replace the word "token" with our generated access token.

3. Create Task: We enter the required data in the request body (title, description, status, due_date).
Access route: http://localhost:8990/tasks method POST

4. Get Tasks: http://localhost:8990/tasks method GET

5. Get Tasks filter by status and due_date: http://localhost:8990/tasks?status=pending&due_date=2023-06-30 method GET

6. Show Task: http://localhost:8990/tasks/{id} method GET

7. Update Task: We enter the data we want to update.
Access route: http://localhost:8990/tasks/{id} method PUT

8. Delete Task: http://localhost:8990/tasks/{id} method DELETE

## Tests

1. To run the tests, we access our container using the following command:
```sh
docker exec -it app bash
```
2. Once inside our container, we execute the following command:
```sh
php artisan test
```
This runs the test observer in interactive mode.

## Access phpMyAdmin

We access through the following link: http://localhost:8080
This will load the administrator of our database.
