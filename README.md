# CMS Backend System
## 🚀 Overview
Content Management System (CMS) backend built with Laravel, featuring user authentication, role-based access control, and RESTful APIs.

## 🖥️ Frontend Dashboard (Blade Laravel)
This CMS includes a Laravel Blade-based frontend interface that interacts with the backend via APIs .

Access it locally at:  
🔗 http://127.0.0.1:8000

## ✨ Features
- User Authentication using Laravel Sanctum
- Role-based Access Control (RBAC)
- Product Management System
- Order Management
- RESTful API Endpoints
- Docker Support


## 🔧 Prerequisites
- PHP >= 8.1
- Composer
- MySQL/PostgreSQL
- Docker (optional)

## 🛠️ Installation

1. Clone the repository
```bash
git clone https://github.com/AhmedShabaan10/cms-backend.git
cd cms-backend
```
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

| Role         | Email           | Password |
| ------------ | --------------- | -------- |
| Super Admin  | admin@admin.com | 123456   |
| Admin (RBAC) | user@admin.com  | 123456   |

- **Super Admin** has full unrestricted access.
- **Admin** is assigned the `admin` role and has controlled permissions.


## 🐳 Docker Setup (Optional)

> You can optionally run the CMS backend using Docker and Docker Compose.  
> This is not required if you prefer to run the project manually on your local machine.


### 1. Build and Run the Containers

```bash
docker-compose up -d --build
```

Access the container and run the setup as usual:

```bash
docker exec -it CMS-app bash
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate
php artisan db:seed
```

🛑 Stop the Containers
```bash
docker-compose down
```

## 🧾 License
This project is open-source and available under the [MIT License](LICENSE).
