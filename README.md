# Andarz Web Backend

Laravel 13 REST API backend for the [andarz-web](https://github.com/nortadzhiev-rustam/andarz-web) educational platform (Next.js frontend).

## Architecture

```
app/
├── Http/
│   ├── Controllers/Api/
│   │   ├── AuthController.php
│   │   ├── CourseController.php
│   │   ├── BlogController.php
│   │   └── InstructorController.php
│   ├── Middleware/
│   │   ├── AdminMiddleware.php
│   │   └── ForceJsonResponse.php
│   ├── Requests/             # Form Request validation
│   │   ├── Auth/, Course/, Blog/, Instructor/
│   └── Resources/            # JSON API transformers (camelCase output)
│       ├── CourseResource.php, CourseModuleResource.php, CourseLessonResource.php
│       ├── BlogPostResource.php, InstructorResource.php, UserResource.php
├── Models/
│   ├── User.php              # role: student | instructor | admin
│   ├── Instructor.php
│   ├── Course.php            # with modules, lessons, instructor
│   ├── CourseModule.php
│   ├── CourseLesson.php
│   └── BlogPost.php
├── Providers/
│   └── AppServiceProvider.php   # binds interfaces → implementations
├── Repositories/
│   ├── Contracts/               # RepositoryInterface + domain interfaces
│   └── Eloquent*Repository.php  # Eloquent implementations
└── Services/
    ├── AuthService.php
    ├── CourseService.php
    ├── BlogService.php
    └── InstructorService.php
```

## Domain Models (match andarz-web TypeScript types)

### Course
All fields are returned in **camelCase** to exactly match the frontend `Course` TypeScript type:
`id`, `title`, `slug`, `description`, `shortDescription`, `thumbnail`, `price`, `discountPrice`,
`level`, `category`, `tags`, `instructor` (nested), `modules` (nested with lessons), `duration`,
`studentsCount`, `rating`, `reviewsCount`, `language`, `lastUpdated`, `isPublished`, `isFeatured`

### User
`id`, `name`, `email`, `avatar`, `role` (student|instructor|admin), `enrolledCourses[]`, `createdAt`

### BlogPost
`id`, `title`, `slug`, `excerpt`, `content`, `thumbnail`, `author` (nested Instructor),
`tags`, `category`, `publishedAt`, `readingTime`, `isPublished`

## API Endpoints

### Authentication
| Method | Endpoint            | Auth | Description       |
|--------|---------------------|------|-------------------|
| POST   | /api/auth/register  | No   | Register (role=student) |
| POST   | /api/auth/login     | No   | Login, get token  |
| POST   | /api/auth/logout    | Yes  | Revoke token      |
| GET    | /api/auth/me        | Yes  | Current user + enrollments |

### Courses
| Method | Endpoint                      | Auth  | Admin | Description        |
|--------|-------------------------------|-------|-------|--------------------|
| GET    | /api/courses                  | No    | No    | All published (filterable by `?category=&level=&featured=1`) |
| GET    | /api/courses/featured         | No    | No    | Featured only      |
| GET    | /api/courses/by-slug/{slug}   | No    | No    | By slug            |
| GET    | /api/courses/{id}             | No    | No    | By ID              |
| POST   | /api/courses/{id}/enroll      | Yes   | No    | Enroll             |
| POST   | /api/courses                  | Yes   | Yes   | Create             |
| PUT    | /api/courses/{id}             | Yes   | Yes   | Update             |
| DELETE | /api/courses/{id}             | Yes   | Yes   | Delete             |

### Blog
| Method | Endpoint                   | Auth | Admin | Description |
|--------|----------------------------|------|-------|-------------|
| GET    | /api/blog                  | No   | No    | All published posts |
| GET    | /api/blog/by-slug/{slug}   | No   | No    | By slug     |
| GET    | /api/blog/{id}             | No   | No    | By ID       |
| POST   | /api/blog                  | Yes  | Yes   | Create      |
| PUT    | /api/blog/{id}             | Yes  | Yes   | Update      |
| DELETE | /api/blog/{id}             | Yes  | Yes   | Delete      |

### Instructors
| Method | Endpoint                   | Auth | Admin | Description |
|--------|----------------------------|------|-------|-------------|
| GET    | /api/instructors           | No   | No    | List        |
| GET    | /api/instructors/{id}      | No   | No    | Show        |
| POST   | /api/instructors           | Yes  | Yes   | Create      |
| PUT    | /api/instructors/{id}      | Yes  | Yes   | Update      |
| DELETE | /api/instructors/{id}      | Yes  | Yes   | Delete      |

## Getting Started

```bash
composer install
cp .env.example .env
php artisan key:generate
touch database/database.sqlite
php artisan migrate
php artisan db:seed      # seeds demo admin, courses, blog posts
php artisan serve
```

API available at `http://localhost:8000/api`.

## Authentication

Laravel Sanctum bearer tokens.

```
Authorization: ******
```

## Demo Credentials (after seeding)

| Role    | Email                   | Password |
|---------|-------------------------|----------|
| Admin   | admin@andarz.test       | password |
| Student | student@andarz.test     | password |

## Connecting to the Frontend

In your `andarz-web` `.env.local`:

```
NEXT_PUBLIC_API_URL=http://localhost:8000/api
```

Then replace `src/lib/api.ts` mock functions to call this backend.

## Testing

```bash
php artisan test   # 35 feature tests
```
