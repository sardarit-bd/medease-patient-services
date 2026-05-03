<!-- <p align="center">
  <img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="340" alt="Laravel Logo"/>
</p> -->

<h1 align="center">Laravel API Boilerplate</h1>

<p align="center">
  A clean, modular REST API starter kit built with Laravel & Sanctum — featuring module-based architecture, DTO pattern, and standardized API responses.
</p>

<!-- <p align="center">
  <a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"/></a>
  <a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"/></a>
  <a href="https://opensource.org/licenses/MIT"><img src="https://img.shields.io/badge/license-MIT-blue.svg" alt="License"/></a>
</p> -->

---

## Table of Contents

- [Overview](#overview)
- [Tech Stack](#tech-stack)
- [Project Structure](#project-structure)
- [Requirements](#requirements)
- [Installation](#installation)
- [Database Setup](#database-setup)
- [Running the Application](#running-the-application)
- [API Endpoints](#api-endpoints)
- [Authentication](#authentication)
- [Request Examples](#request-examples)
- [License](#license)

---

## Overview

This boilerplate provides a production-ready foundation for building REST APIs with Laravel. It follows a **modular architecture** where each feature (Auth, User, etc.) lives in its own self-contained module under `app/Modules/`, keeping the codebase clean and scalable.

Key patterns used:

- **DTO (Data Transfer Object)** — clean data passing between layers
- **Service Layer** — business logic separated from controllers
- **Form Requests** — validation isolated per request type
- **Sanctum Token Auth** — stateless API authentication
- **Unified API Response** — consistent JSON response structure

---

## Tech Stack

| Technology      | Version |
| --------------- | ------- |
| PHP             | ^8.2    |
| Laravel         | ^11.x   |
| Laravel Sanctum | ^4.x    |
| MySQL / SQLite  | Any     |

---

## Project Structure

```
app/
├── Exceptions/
│   └── Handler.php              # Global exception handling
├── Helpers/
│   └── ApiResponse.php          # Unified JSON response helper
├── Http/
│   ├── Controllers/
│   │   └── Controller.php
│   └── Requests/
│       └── BaseRequest.php      # Shared base form request
├── Models/
│   └── User.php
├── Modules/
│   ├── Auth/                    # Authentication module
│   │   ├── Controllers/
│   │   │   └── AuthController.php
│   │   ├── DTOs/
│   │   │   ├── LoginDTO.php
│   │   │   └── RegisterDTO.php
│   │   ├── Requests/
│   │   │   ├── LoginRequest.php
│   │   │   └── RegisterRequest.php
│   │   ├── Routes/
│   │   │   └── api.php
│   │   └── Services/
│   │       └── AuthService.php
│   └── User/                    # User management module
│       ├── Controllers/
│       │   └── UserController.php
│       ├── DTOs/
│       │   ├── CreateUserDTO.php
│       │   └── UpdateUserDTO.php
│       ├── Requests/
│       │   ├── CreateUserRequest.php
│       │   └── UpdateUserRequest.php
│       ├── Routes/
│       │   └── api.php
│       └── Services/
│           └── UserService.php
└── Providers/
    └── AppServiceProvider.php
```

---

## Requirements

Before you begin, ensure you have the following installed:

- **PHP** >= 8.2
- **Composer** >= 2.x
- **MySQL** >= 8.0 (or SQLite for local development)
- **Node.js** >= 18.x (optional, for frontend assets)

---

## Installation

**1. Clone the repository**

```bash
git clone https://github.com/shahinsamiur/laravel_stater_template
cd laravel_stater_template
```

**2. Install PHP dependencies**

```bash
composer install
```

**3. Copy the environment file**

```bash
cp .env.example .env
```

**4. Generate the application key**

```bash
php artisan key:generate
```

---

## Database Setup

**1. Configure your database in `.env`**

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=your_database_name
DB_USERNAME=your_database_user
DB_PASSWORD=your_database_password
```

> 💡 For quick local development, you can use SQLite:
>
> ```env
> DB_CONNECTION=sqlite
> ```
>
> Then create the file: `touch database/database.sqlite`

**2. Run migrations**

```bash
php artisan migrate
```

**3. (Optional) Seed the database**

```bash
php artisan db:seed
```

---

## Running the Application

**Start the development server**

```bash
php artisan serve
```

The API will be available at: `http://127.0.0.1:8000`

**Run with a custom port**

```bash
php artisan serve --port=8080
```

---

## API Endpoints

### Auth Routes (Public)

| Method | Endpoint             | Description             |
| ------ | -------------------- | ----------------------- |
| `POST` | `/api/auth/register` | Register a new user     |
| `POST` | `/api/auth/login`    | Login and receive token |

### User Routes (Protected — requires Bearer Token)

| Method   | Endpoint          | Description       |
| -------- | ----------------- | ----------------- |
| `GET`    | `/api/users`      | List all users    |
| `GET`    | `/api/users/{id}` | Get a single user |
| `POST`   | `/api/users`      | Create a new user |
| `PUT`    | `/api/users/{id}` | Update a user     |
| `DELETE` | `/api/users/{id}` | Delete a user     |

---

## Authentication

This API uses **Laravel Sanctum** for token-based authentication.

**1. Register or Login** to receive a token:

```json
POST /api/auth/login
{
    "email": "admin@example.com",
    "password": "password123"
}
```

**2. Include the token** in all protected requests:

```
Authorization: Bearer YOUR_TOKEN_HERE
Content-Type: application/json
```

---

## Request Examples

### Register a User

```json
POST /api/auth/register
{
    "name": "John Doe",
    "email": "john@example.com",
    "password": "secret1234",
    "password_confirmation": "secret1234"
}
```

### Create a User (Admin)

```json
POST /api/users
Authorization: Bearer YOUR_TOKEN

{
    "name": "Jane Doe",
    "email": "jane@example.com",
    "password": "secret1234",
    "password_confirmation": "secret1234"
}
```

### Update a User

```json
PUT /api/users/1
Authorization: Bearer YOUR_TOKEN

{
    "name": "Jane Updated",
    "email": "jane_updated@example.com"
}
```

> ⚠️ Always send requests with `Content-Type: application/json` and use **raw JSON** body — not `form-data` — especially for `PUT` requests.

---

<!-- ## License

This project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT). -->
