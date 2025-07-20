# CMS Backend System

## 🚀 Overview
A robust Content Management System (CMS) backend built with Laravel, featuring user authentication, role-based access control, and RESTful APIs.

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
git clone https://github.com/yourusername/cms-backend.git
cd cms-backend
```

2. Install dependencies
```bash
composer install
npm install
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

## 📚 API Documentation
API endpoints documentation available at 

## 🧪 Running Tests
Run all tests:
```bash
php artisan test
```

Run specific test:
```bash
php artisan test --filter=OrderDetailsServiceTest
```
