
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
   php artisan migrate --seed
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

## Postman Collection
A Postman collection is included in the repository under `docs/postman_collection.json`. Import it into Postman to test the API endpoints.
