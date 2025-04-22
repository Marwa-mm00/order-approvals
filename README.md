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
- **[Kirschbaum Development Group](https://kirschbaumdevelopment.com)**
- **[64 Robots](https://64robots.com)**
- **[Curotec](https://www.curotec.com/services/technologies/laravel/)**
- **[DevSquad](https://devsquad.com/hire-laravel-developers)**
- **[Redberry](https://redberry.international/laravel-development/)**
- **[Active Logic](https://activelogic.com)**

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

# Order Approvals System

## Overview
This Laravel application handles a business approval workflow for processing orders. It includes features such as order creation, validation, approval, and status tracking.

## Features
- Auto-generation of unique and sequential order numbers.
- Order creation with multiple items.
- Total calculation for orders.
- Approval workflow for orders above $1000.
- Status tracking and order history.

## Setup Instructions

### Prerequisites
- PHP 8.1 or higher
- Composer
- SQLite (or another database supported by Laravel)

### Installation
1. Clone the repository:
   ```bash
   git clone <repository-url>
   cd order-approvals
   ```

2. Install dependencies:
   ```bash
   composer install
   ```

3. Set up the environment file:
   ```bash
   cp .env.example .env
   ```
   Update the `.env` file with your database configuration.

4. Run migrations:
   ```bash
   php artisan migrate
   ```

5. Start the development server:
   ```bash
   php artisan serve
   ```

### Running Tests
To run the unit tests:
```bash
php artisan test
```

## API Documentation

### Endpoints

#### Create Order
- **URL:** `/orders`
- **Method:** `POST`
- **Request Body:**
  ```json
  {
    "customer_name": "John Doe",
    "items": [
      {"item_name": "Item 1", "quantity": 2, "price": 50},
      {"item_name": "Item 2", "quantity": 1, "price": 100}
    ]
  }
  ```
- **Response:**
  ```json
  {
    "order": {
      "id": 1,
      "order_number": "ORD000001",
      "total": 200,
      "status": "pending",
      "items": [...]
    }
  }
  ```

#### View Order
- **URL:** `/orders/{order}`
- **Method:** `GET`
- **Response:**
  ```json
  {
    "order": {
      "id": 1,
      "order_number": "ORD000001",
      "total": 200,
      "status": "pending",
      "items": [...]
    }
  }
  ```

#### Approve Order
- **URL:** `/orders/{order}/approve`
- **Method:** `POST`
- **Response:**
  ```json
  {
    "order": {
      "id": 1,
      "order_number": "ORD000001",
      "total": 200,
      "status": "approved"
    }
  }
  ```

#### View Order History
- **URL:** `/orders/{order}/history`
- **Method:** `GET`
- **Response:**
  ```json
  {
    "history": [
      {"status": "pending", "changed_at": "2025-04-22T10:00:00Z"},
      {"status": "approved", "changed_at": "2025-04-22T12:00:00Z"}
    ]
  }
  ```

## Postman Collection
A Postman collection is included in the repository under `docs/postman_collection.json`. Import it into Postman to test the API endpoints.
