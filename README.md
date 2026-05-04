# Med'ease API

A modular REST API built with Laravel 13 for the Med'ease healthcare platform. Each feature lives in its own self-contained module under `app/Modules/`, keeping the codebase clean and scalable.

---

## Tech Stack

| Technology      | Version |
| --------------- | ------- |
| PHP             | ^8.3    |
| Laravel         | ^13.0   |
| Laravel Sanctum | ^4.3    |
| SQLite / MySQL  | Any     |

---

## Project Structure

```
app/
├── Helpers/
│   └── ApiResponse.php          # Unified JSON response format
├── Models/                      # All Eloquent models
├── Modules/
│   ├── Auth/                    # Register, Login, Forgot Password
│   ├── User/                    # Patient profile management
│   ├── Medications/             # Today's treatments, intake log, vaccination
│   ├── inventory/               # Stock levels, expiry alerts
│   └── Finance/                 # Expenses, prescriptions
└── Providers/
    └── AppServiceProvider.php
```

---

## Requirements

- PHP >= 8.3
- Composer >= 2.x
- SQLite (local) or MySQL >= 8.0

---

## Setup

### 1. Clone the repository

```bash
git clone hhttps://github.com/sardarit-bd/medease-patient-services
cd medease-patient-services
```

### 2. Install dependencies

```bash
composer install
```

### 3. Create environment file

```bash
cp .env.example .env
php artisan key:generate
```

### 4. Configure database

**Option A — SQLite (local development, quickest)**

```env
DB_CONNECTION=sqlite
```

Then create the database file:

```bash
touch database/database.sqlite
```

**Option B — MySQL (production)**

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=med_ease
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

### 5. Run migrations

```bash
php artisan migrate
```

### 6. Seed the database

```bash
php artisan db:seed
```

### 7. Start the server

```bash
php artisan serve
```

API available at: `http://127.0.0.1:8000`

---

## Authentication

This API uses **Laravel Sanctum** for token-based authentication.

**Step 1 — Register or login to get a token:**

```json
POST /api/auth/login
```

**Step 2 — Include the token in all protected requests:**

```
Authorization: Bearer YOUR_TOKEN_HERE
Content-Type: application/json
Accept: application/json
```

---

## Notes

- Always send requests with `Content-Type: application/json` and `Accept: application/json`
- Use **raw JSON** body — not `form-data` — for all requests
- All IDs are UUIDs
- Soft deleted records are excluded from all queries by default
