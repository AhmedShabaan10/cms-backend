# CMS Backend System

![Laravel](https://img.shields.io/badge/Laravel-10.x-red)
![License](https://img.shields.io/github/license/AhmedShabaan10/cms-backend)
![Tests](https://img.shields.io/badge/tests-passing-brightgreen)

## 🚀 Overview
Content Management System (CMS) backend built with Laravel, featuring user authentication, role-based access control, and RESTful APIs.

## 🖥️ Frontend Dashboard (Blade Laravel)
This CMS includes a Laravel Blade-based frontend interface that interacts with the backend via shared APIs and services.

Access it locally at:  
🔗 http://127.0.0.1:8000

## ✨ Features
- User Authentication using Laravel Sanctum
- Role-based Access Control (RBAC)
- Product Management System
- Order Management
- RESTful API Endpoints
- Multi-language Support
- Docker Support


## 🔧 Prerequisites
- PHP >= 8.1
- Composer
- MySQL/PostgreSQL
- Node.js & NPM
- Docker (optional)

## 🛠️ Installation

1. Clone the repository
```bash
git clone https://github.com/AhmedShabaan10/cms-backend.git
cd cms-backend

2. Install dependencies
```bash
composer install
```

3. Environment setup
```bash
cp .env.example .env
php artisan key:generate
```

4. Database setup
```bash
php artisan migrate
php artisan db:seed
```

## 🔑 API Authentication
This project uses Laravel Sanctum for API authentication. To authenticate:

1. Register a new user
2. Login to receive your authentication token
3. Include the token in your request headers:
```bash
Authorization: Bearer <your-token>
```

## 🧪 Running Tests
Run all tests:
```bash
php artisan test
```

Run specific test:
```bash
php artisan test --filter=OrderDetailsServiceTest
```

## 🔐 Default Admin Credentials

> Seeded by `AdminSeeder.php`

| Role           | Email              | Password |
|----------------|--------------------|----------|
| Super Admin    | admin@admin.com    | 123456   |
| Admin (RBAC)   | user@admin.com     | 123456   |

- **Super Admin** has full unrestricted access.
- **Admin** is assigned the `admin` role and has controlled permissions.