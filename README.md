# Job Board Application

A full-stack job board platform built with **Laravel** (Backend API) and **Nuxt 4** (Frontend).

## 🚀 Features

- **Authentication**: Secure user registration, login, and logout using Laravel Sanctum.
- **Job Listings**: Browse jobs with server-side pagination and real-time search filters.
- **Job Management**: Full CRUD operations for job listings (Create, Read, Update, Delete).
- **TypeScript Support**: Strongly typed frontend logic with Vue 3 Composition API.
- **Clean Architecture**: Uses Service-Repository patterns and API Resources for a structured backend.

## 🛠️ Tech Stack

### Backend

- **Framework**: Laravel 13
- **Authentication**: Laravel Sanctum (SPA Authentication)
- **Database**: MySQL
- **Features**: Eloquent Models, API Resources, Form Requests.

### Frontend

- **Framework**: Nuxt 4
- **UI**: Vue 3 (Composition API)
- **Styling**: Tailwind CSS
- **Language**: TypeScript

---

## 📂 Project Structure

```text
job-board/
├── server/      # Laravel Backend
│   ├── app/     # Core logic (Models, Controllers, Services)
│   ├── routes/  # API route definitions
│   └── database/ # Migrations and Factories
└── client/      # Nuxt Frontend
    ├── components/
    ├── pages/   # Application Views
    ├── composables/ # Shared Logic (useJobs, etc.)
    └── middleware/  # Auth protection
```

---

## 🛣️ API Endpoints

### Public Routes

| Method | Endpoint        | Description            |
| :----- | :-------------- | :--------------------- |
| `POST` | `/api/register` | Register a new account |
| `POST` | `/api/login`    | Authenticate a user    |

### Protected Routes (Requires Sanctum Token)

| Method   | Endpoint         | Description                           |
| :------- | :--------------- | :------------------------------------ |
| `POST`   | `/api/logout`    | Revoke current session                |
| `GET`    | `/api/jobs`      | List jobs (supports `filter[search]`) |
| `POST`   | `/api/jobs`      | Create a new job listing              |
| `GET`    | `/api/jobs/{id}` | View specific job details             |
| `PUT`    | `/api/jobs/{id}` | Update an existing job                |
| `DELETE` | `/api/jobs/{id}` | Remove a job listing                  |

---

## ⚙️ Installation

### Backend Setup

1. Navigate to the server directory: `cd server`
2. Install dependencies: `composer install`
3. Copy environment file: `cp .env.example .env`
4. Generate app key: `php artisan key:generate`
5. Run migrations: `php artisan migrate`
6. Start the server: `php artisan serve`

### Frontend Setup

1. Navigate to the client directory: `cd client`
2. Install dependencies: `npm install`
3. Start development server: `npm run dev`

---

## 📝 Usage Notes

### Job Filtering

The `GET /api/jobs` endpoint accepts a `filter[search]` query parameter. It searches across:

- Job Title
- Description
- Location

### Frontend Authentication

The Nuxt app uses an `auth` middleware to protect routes like `/jobs/create`. Authentication state is managed via composables interacting with the Laravel Sanctum API.
