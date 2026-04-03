# Andarz Web Backend

A RESTful API backend for the **Andarz** (quotes & sayings) web application, built with **Laravel 13**.

## Architecture

```
app/
├── Http/
│   ├── Controllers/Api/        # Thin controllers — delegate to services
│   │   ├── AuthController.php
│   │   ├── AuthorController.php
│   │   ├── CategoryController.php
│   │   └── QuoteController.php
│   ├── Middleware/
│   │   ├── AdminMiddleware.php      # Role-based access guard
│   │   └── ForceJsonResponse.php   # Forces JSON Accept header
│   ├── Requests/                   # Form Request validation
│   │   ├── Auth/, Author/, Category/, Quote/
│   └── Resources/                  # JSON API transformers
│       ├── AuthorResource.php, CategoryResource.php
│       ├── QuoteResource.php, UserResource.php
├── Models/                         # User, Quote, Category, Author
├── Providers/
│   └── AppServiceProvider.php      # Binds interfaces → implementations
├── Repositories/
│   ├── Contracts/                  # Repository interfaces
│   └── Eloquent*Repository.php     # Eloquent implementations
└── Services/
    ├── AuthService.php, AuthorService.php
    ├── CategoryService.php, QuoteService.php
```

## API Endpoints

### Authentication
| Method | Endpoint             | Auth | Description          |
|--------|----------------------|------|----------------------|
| POST   | /api/auth/register   | No   | Register             |
| POST   | /api/auth/login      | No   | Login & get token    |
| POST   | /api/auth/logout     | Yes  | Revoke token         |
| GET    | /api/auth/me         | Yes  | Current user         |

### Quotes
| Method | Endpoint              | Auth | Admin | Description       |
|--------|-----------------------|------|-------|-------------------|
| GET    | /api/quotes           | No   | No    | List active        |
| GET    | /api/quotes/featured  | No   | No    | Featured quotes    |
| GET    | /api/quotes/random    | No   | No    | Random quote       |
| GET    | /api/quotes/{id}      | No   | No    | Single quote       |
| POST   | /api/quotes           | Yes  | No    | Create             |
| PUT    | /api/quotes/{id}      | Yes  | No    | Update             |
| DELETE | /api/quotes/{id}      | Yes  | No    | Delete             |

### Categories & Authors
| Method | Endpoint              | Auth | Admin | Description |
|--------|-----------------------|------|-------|-------------|
| GET    | /api/categories       | No   | No    | List        |
| GET    | /api/categories/{id}  | No   | No    | Show        |
| POST   | /api/categories       | Yes  | Yes   | Create      |
| PUT    | /api/categories/{id}  | Yes  | Yes   | Update      |
| DELETE | /api/categories/{id}  | Yes  | Yes   | Delete      |

_(same pattern for /api/authors)_

## Getting Started

```bash
composer install
cp .env.example .env
php artisan key:generate
touch database/database.sqlite
php artisan migrate
php artisan db:seed      # optional demo data
php artisan serve
```

The API is available at `http://localhost:8000/api`.

## Authentication

Uses **Laravel Sanctum** bearer tokens.

```
Authorization: Bearer {token}
```

## Demo Credentials (after seeding)

| Role  | Email              | Password |
|-------|--------------------|----------|
| Admin | admin@andarz.test  | password |
| User  | user@andarz.test   | password |

## Testing

```bash
php artisan test
```
