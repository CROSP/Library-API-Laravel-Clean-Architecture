# Laravel Clean Architecture Example

This repository demonstrates a **Clean Architecture** / **DDD** approach in Laravel, featuring two contexts:
- **User Context** (registration, login, role-based auth)
- **Book Context** (library books, with domain events on create/update/delete)

Additional features:
- **JWT Authentication** (using `tymon/jwt-auth`)
- **Role-based middleware** (librarian vs. member)
- **Request validation** using FormRequest classes
- **Mapper** classes to convert Domain Entities <-> Eloquent Models
- **Domain Events** dispatched in BookService
- **Docker** setup (PHP-FPM + MySQL)
- **Swagger** (L5-Swagger) for API documentation
- **Seeders** for initial data

## 1. Requirements

- PHP 8.1+
- Composer
- Docker & Docker Compose (if you want to run in containers)

## 2. Installation

1. **Clone** this repo:
   ```bash
   git clone https://github.com/your-repo/clean-architecture-laravel.git
   cd clean-architecture-laravel
