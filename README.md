
# LibraryAPI - Clean Architecture Example

This project demonstrates a **Clean Architecture** / **DDD** approach in Laravel, featuring **two contexts**:

1. **User Context**

    - Registration (with roles like `librarian` or `member`)
    - For sake of simplicity we are not using a separate Role model, just a field
    - Login / Logout with **JWT** (via `tymon/jwt-auth`)
    - Role-based actions (only `librarian` can create/update/delete books)

2. **Book Context**

    - CRUD for library books (title, publisher, author, genre, etc.)
    - Domain events (e.g., `BookCreatedEvent`, `BookUpdatedEvent`, `BookDeletedEvent`) fired from **BookService**

Additional features include:

- **Docker** & **Docker Compose** for local development (PHP-FPM + MySQL).
- **FormRequest** classes for validation.
- **Mapper** classes to convert **Domain Entities** <-> **Eloquent Models**.
- **Seeders** for initial data (two users + multiple books).
- **Testing** (Unit & Feature) for critical flows.
- **Swagger** (via L5-Swagger) for API documentation.

---

## Table of Contents

1. [Requirements](#requirements)
2. [Installation](#installation)
3. [Running Locally (Without Docker)](#running-locally-without-docker)
4. [Running with Docker](#running-with-docker)
5. [Seeding Data](#seeding-data)
6. [Testing](#testing)
7. [API Endpoints & Swagger](#api-endpoints--swagger)
8. [Architecture Overview](#architecture-overview)
9. [Contributing](#contributing)
10. [License](#license)

---

## Requirements

- **PHP 8.1+**
- **Composer**
- **MySQL** or another supported database
- **Docker & Docker Compose** (if you want to run it in containers)

---

## Installation

1. **Clone** this repository:

   ```bash
   git clone https://github.com/CROSP/Library-API-Laravel-Clean-Architecture.git
   cd library-api
   ```

2. Install Composer Dependencies:

   ```bash
   composer install
   ```

3. Copy the `.env.example` to `.env` and adjust as needed (DB credentials, `JWT_SECRET`, etc.):

   ```bash
   cp .env.example .env
   php artisan key:generate
   php artisan jwt:secret
   ```

4. Migrate and Seed:

   ```bash
   php artisan migrate
   php artisan db:seed
   ```

   This will create:

    - 2 users (one librarian, one member)
    - Multiple sample books

   If you do not want seeded data, you can omit the seed. However, having a librarian/user helps test role-based behavior quickly.

---

## Running Locally (Without Docker)

If you have PHP & MySQL running locally:

1. Start the application:

   ```bash
   php artisan serve
   ```

2. Visit [http://127.0.0.1:8000](http://127.0.0.1:8000).

3. Test the API endpoints (see below) or, if installed, view Swagger docs at `/api/documentation`.

---

## Running with Docker

If you prefer Docker:

1. Make sure you have Docker and Docker Compose installed.

2. Build and start containers:

   ```bash
   docker-compose up -d --build
   ```

   This spins up a `php-fpm` container (exposed on port 9000) and a `mysql` container (exposed on port 3306).

   If you need a separate container for Nginx or to map ports differently, edit the `docker-compose.yml`. Otherwise, you can use `php artisan serve` inside the container or map an Nginx container on port 80.

3. Check logs with:

   ```bash
   docker-compose logs -f
   ```

---

## Seeding Data

We provide seeders in the `database/seeders` folder:

- **UserSeeder**: Creates one librarian and one member.
- **BookSeeder**: Creates multiple book records.
- **DatabaseSeeder**: Runs both automatically.

Run them manually if needed:

```bash
php artisan db:seed
```

---

## Testing

We use PHPUnit tests in `tests/Feature` (for HTTP endpoints) and `tests/Unit` (for domain logic).

To run tests:

```bash
php artisan test
```

or

```bash
./vendor/bin/phpunit
```

Examples:

- **AuthControllerTest**: Tests register & login flows, verifying role-based restrictions.
- **BookControllerTest**: Tests CRUD endpoints, ensuring only librarian can create/update/delete.
- **BookServiceTest**: A Unit Test for domain logic (validating book price, emitting events, etc.).

---

## API Endpoints & Swagger

### Auth:

- **POST** `/api/register` (register new user, returns JWT)
- **POST** `/api/login` (login, returns JWT)
- **POST** `/api/logout` (logout, requires JWT)
- **GET** `/api/profile` (fetch current user, requires JWT)

### Books:

- **GET** `/api/books` (list all books, requires JWT)
- **GET** `/api/books/{id}` (show a book, requires JWT)
- **POST** `/api/books` (create book, requires JWT + librarian role)
- **PATCH** `/api/books/{id}` (update book, requires JWT + librarian role)
- **DELETE** `/api/books/{id}` (delete book, requires JWT + librarian role)

If Swagger (via L5-Swagger) is set up, you can:

1. Generate docs:

   ```bash
   php artisan l5-swagger:generate
   ```

2. Open [http://127.0.0.1:8000/api/documentation](http://127.0.0.1:8000/api/documentation) to see the interactive Swagger page.

---

## Architecture Overview

### Contexts:

#### User Context

- **Domain**: `UserEntity`, `UserRepositoryInterface`, `UserService`, etc.
- **Infrastructure**: `UserModel`, `AuthController`, `EloquentUserRepository`, `UserMapper`, etc.

#### Book Context

- **Domain**: `BookEntity`, `BookRepositoryInterface`, `BookService`, domain events (`BookCreatedEvent`, etc.).
- **Infrastructure**: `BookModel`, `BookController`, `EloquentBookRepository`, `BookMapper`, etc.

### Layers:

- **Domain**: Contains Entities, Domain Services, Interfaces, Domain Events.
- **Infrastructure**: Contains Eloquent models, repository implementations, mappers, controllers, etc.
- **Application** (optional, or folded into domain services): Could hold use cases.

### Key Points:

- Service classes (e.g., `UserService`, `BookService`) contain business logic.
- Repositories handle database operations, converting domain entities <-> Eloquent models (via mappers).
- `RoleMiddleware` ensures only librarians can mutate book data.
- Domain Events (`BookCreatedEvent`, etc.) are fired in the service layer after create/update/delete.

---

## Contributing

1. Fork this repository.
2. Create a feature branch.
3. Submit a Pull Request describing your changes.

We appreciate bug reports, feature requests, and feedback.

---

## License

This project is open-sourced software licensed under the [MIT license](LICENSE).
