<div align="center">

# 🏋️ PulseForce — Gym Management System

**A modern, full-stack gym management web application built with Laravel & MongoDB.**

[![Laravel](https://img.shields.io/badge/Laravel-12.x-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)](https://laravel.com)
[![MongoDB](https://img.shields.io/badge/MongoDB-7.x-47A248?style=for-the-badge&logo=mongodb&logoColor=white)](https://www.mongodb.com)
[![PHP](https://img.shields.io/badge/PHP-8.2+-777BB4?style=for-the-badge&logo=php&logoColor=white)](https://www.php.net)
[![Vite](https://img.shields.io/badge/Vite-7.x-646CFF?style=for-the-badge&logo=vite&logoColor=white)](https://vitejs.dev)
[![License](https://img.shields.io/badge/License-MIT-blue?style=for-the-badge)](LICENSE)

</div>

---

## 📖 Introduction

**PulseForce** is a feature-rich gym management platform designed to streamline the operations of fitness centers and enhance the experience for both gym managers and members. Built on **Laravel 12** with a **MongoDB** database backend, it delivers a sleek, responsive interface with role-based access control, real-time member tracking, and a rich catalog of fitness features.

Admins can manage memberships, assign workout & diet programs, block/activate members, and generate reports. Members get a fully interactive personal hub — tracking daily workouts, logging meals, and recording attendance in real-time.

---

## ✨ Features

### 🔐 Authentication & Security
- **Email/Password** registration and login with strong password validation (mixed case, numbers, symbols)
- **Google Sign-In** via Firebase Authentication
- **Forgot Password** flow with email-based reset links (Laravel Password Broker)
- Session-based authentication with CSRF protection

### 👨‍💼 Admin (Manager) Dashboard
- **Overview Metrics** — Total revenue, active members, pending signups count
- **Pending Signup Alerts** — New members who register via the website are flagged as "Pending" and shown in the Quick Actions panel with a badge count
- **Member Management** — Search by name/email, filter by status (All / Active / Pending / Blocked), view all members with their assigned plans
- **Activate Members** — One-click activation with plan selection for new signups
- **Assign Programs** — Assign specific workout programs (goal + level) and diet plans (goal + type) to individual members directly from the members table
- **Block / Unblock** — Toggle member access; blocked members cannot log in
- **Delete Members** — Permanently remove a member with confirmation modal (also cleans up their workout, diet, and attendance records)
- **CSV Report Export** — Download a full member report as a `.csv` file
- **Add Members** — Directly create new customer accounts with plan assignment

### 👤 Member (Customer) Hub
- **Tabbed Dashboard** — Clean layout with three tabs: Workout, Today's Meals, Attendance
- **Workout Tracker** — View assigned workout program; check off exercises per day with live progress bar (AJAX, no page reload)
- **Diet / Meal Logger** — Log each meal item as eaten with macro-nutrient pills (Protein / Carbs / Fat); 2-column layout showing all meals at once
- **Attendance Calendar** — Monthly calendar view showing check-in days; streak counter and attendance rate
- **Daily Check-In** — One-click gym check-in button in the header
- **Personalized Browse** — Browse Workouts and Browse Diets pages show a contextual banner: assigned program is highlighted, other programs show "your trainer assigned X" reminder
- **Profile Management** — Update name, email, and upload a profile avatar

### 🏋️ Feature Pages (Public & Member)
- **Training Programs** — Browse workout routines (Bulk / Shredded × Beginner / Intermediate / Veteran)
- **Diet Plans** — Browse nutrition plans (Bulk / Slim × Veg / Non-Veg / Vegan)
- **Premium Merchandise** — Shop exclusive gym apparel and supplements
- **Memberships** — View and compare available membership tiers

### 🎨 Design & UX
- Fully responsive, mobile-first design
- Custom CSS with light/warm theme, gradients, and micro-animations
- Animated landing page with hero section, feature marquee, and tech stack ticker
- AJAX interactions for workout/meal toggles — no page reloads

---

## 🛠️ Tech Stack

| Layer        | Technology                                           |
|-------------|------------------------------------------------------|
| **Backend**  | Laravel 12 (PHP 8.2+)                               |
| **Database** | MongoDB 7.x via `mongodb/laravel-mongodb`            |
| **Frontend** | Blade Templates, Vanilla CSS, Vite 7.x              |
| **Auth**     | Laravel Auth + Firebase Google Sign-In               |
| **Tooling**  | Composer, npm, Artisan CLI                           |
| **Mail**     | SMTP (Gmail App Passwords supported)                 |

---

## 🚀 Getting Started

### Prerequisites

Make sure you have the following installed:

- **PHP** >= 8.2 with the [MongoDB PHP extension](https://www.php.net/manual/en/mongodb.installation.php)
- **Composer** >= 2.x
- **MongoDB** >= 7.x (running locally or via MongoDB Atlas)
- **Node.js** >= 18.x & **npm**
- **Git**

### Installation

```bash
# 1. Clone the repository
git clone https://github.com/G4uravXDev/PulseForce.git
cd PulseForce

# 2. Install PHP dependencies
composer install

# 3. Install frontend dependencies
npm install

# 4. Create your environment file
cp .env.example .env       # Linux/macOS
copy .env.example .env     # Windows

# 5. Generate the application key
php artisan key:generate

# 6. Seed the database with sample data
php artisan db:seed --class=MemberSeeder
```

### Configuration

Open the `.env` file and configure:

```env
# App
APP_NAME=PulseForce
APP_URL=http://localhost:8000

# MongoDB Connection
DB_CONNECTION=mongodb
DB_HOST=127.0.0.1
DB_PORT=27017
DB_DATABASE=pulseforce
DB_USERNAME=
DB_PASSWORD=

# Mail (for password resets)
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your-email@gmail.com
MAIL_PASSWORD=your-app-password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS="your-email@gmail.com"
MAIL_FROM_NAME="PulseForce"
```

### Running the Application

```bash
# Start the Laravel development server
php artisan serve

# (In a separate terminal) Start Vite for frontend assets
npm run dev
```

Visit **http://127.0.0.1:8000**

---

## 🌱 Database Seeding

The `MemberSeeder` creates sample accounts for testing:

| Role     | Email                    | Password      | Status  |
|----------|--------------------------|---------------|---------|
| Manager  | `admin@pulseforce.com`   | `password123` | —       |
| Customer | `rahul.s@example.com`    | `password123` | Active  |
| Customer | `priya.p@example.com`    | `password123` | Active  |
| Customer | `vikram.s@example.com`   | `password123` | Pending |
| Customer | `neha.g@example.com`     | `password123` | Active  |
| Customer | `amit.k@example.com`     | `password123` | Active  |

```bash
php artisan db:seed --class=MemberSeeder
```

---

## 🗂️ Project Structure

```
PulseForce/
├── app/
│   ├── Http/
│   │   └── Controllers/
│   │       ├── AuthController.php           # Login, Register, Google Sign-In, Logout
│   │       ├── DashboardController.php      # Admin & Member dashboards, assignments, reports
│   │       ├── DietPlanController.php       # Diet plans data & member assignment view
│   │       ├── ForgotPasswordController.php # Password reset flow
│   │       ├── LandingController.php        # Landing page & feature routing
│   │       ├── MemberController.php         # AJAX: toggle exercises, log meals, check-in
│   │       ├── MerchandiseController.php    # Merchandise feature page
│   │       └── TrainingProgramController.php# Training programs data & member assignment view
│   ├── Models/
│   │   ├── User.php                         # MongoDB User model (roles: manager, customer)
│   │   ├── WorkoutAssignment.php            # Tracks assigned workout + exercise completion
│   │   ├── DietAssignment.php              # Tracks assigned diet + daily meal completion
│   │   └── Attendance.php                  # Daily check-in records
│   └── Providers/
│       └── AppServiceProvider.php
│
├── database/
│   └── seeders/
│       ├── DatabaseSeeder.php
│       └── MemberSeeder.php                 # Sample manager + customer accounts
│
├── public/
│   └── css/
│       ├── admin-dashboard.css              # Admin & member dashboard styles
│       ├── auth.css                         # Login/Register styles
│       └── ...                             # Feature page styles
│
├── resources/
│   └── views/
│       ├── admin/
│       │   ├── dashboard.blade.php          # Manager overview (stats, pending alerts)
│       │   ├── members.blade.php            # Members table (search, filter, assign, delete)
│       │   └── members-create.blade.php     # Add new member form
│       ├── auth/                            # Login, Register, Password Reset views
│       ├── customer/
│       │   └── dashboard.blade.php          # Member Hub (tabbed: Workout / Meals / Attendance)
│       ├── features/                        # Training, Diet, Merchandise, Membership pages
│       └── partials/                        # Loader, profile modal, nav links
│
└── routes/
    └── web.php                              # All application routes
```

---

## 🔀 Application Workflow

```
                    ┌─────────────────────────┐
                    │      Landing Page        │
                    │    (Public — "/" )        │
                    └────────────┬────────────┘
                                 │
                ┌────────────────┼────────────────┐
                ▼                ▼                 ▼
        ┌──────────────┐ ┌─────────────┐  ┌──────────────┐
        │ Feature Pages │ │   Login     │  │  Register    │
        │  (Public)     │ │  /login     │  │  /register   │
        └──────────────┘ └──────┬──────┘  └──────┬───────┘
                                │    Google       │
                                │   Sign-In ──────┤
                                └────────┬────────┘
                                         │
                               ┌─────────▼─────────┐
                               │   Auth Middleware  │
                               └─────────┬─────────┘
                                         │
                          ┌──────────────┼──────────────┐
                          ▼                              ▼
                 ┌─────────────────┐           ┌─────────────────┐
                 │ Manager Dashboard│           │  Member Hub      │
                 │   /dashboard     │           │   /dashboard     │
                 ├─────────────────┤           ├─────────────────┤
                 │• Revenue Stats   │           │• Workout Tracker │
                 │• Pending Alerts  │           │• Meal Logger     │
                 │• Member Search   │           │• Attendance Cal. │
                 │• Assign Programs │           │• Daily Check-In  │
                 │• Block/Unblock   │           │• Browse Programs │
                 │• Delete Member   │           │  (personalized)  │
                 │• Download Report │           └─────────────────┘
                 └─────────────────┘
```

---

## 🛣️ Route References

### Public Routes

| Method | URI                              | Description                |
|--------|----------------------------------|----------------------------|
| GET    | `/`                              | Landing page               |
| GET    | `/features/training-programs`    | Training programs catalog  |
| GET    | `/features/diet-plans`           | Diet plans catalog         |
| GET    | `/features/merchandise`          | Merchandise store          |
| GET    | `/features/memberships`          | Membership tiers           |

### Authentication Routes

| Method | URI                          | Description                    |
|--------|------------------------------|--------------------------------|
| GET    | `/login`                     | Show login form                |
| POST   | `/login`                     | Submit login credentials       |
| GET    | `/register`                  | Show registration form         |
| POST   | `/register`                  | Submit registration            |
| POST   | `/logout`                    | Log out the user               |
| POST   | `/auth/firebase/callback`    | Firebase Google login callback |
| GET    | `/forgot-password`           | Show forgot password form      |
| POST   | `/forgot-password`           | Send password reset email      |
| GET    | `/reset-password/{token}`    | Show reset password form       |
| POST   | `/reset-password`            | Submit new password            |

### Protected Routes (Auth Required)

| Method | URI                                        | Description                          |
|--------|--------------------------------------------|--------------------------------------|
| GET    | `/dashboard`                               | Dashboard (role-based view)          |
| POST   | `/profile/update`                          | Update user profile & avatar         |
| GET    | `/admin/members`                           | View all members (manager)           |
| GET    | `/admin/members/create`                    | Add new member form                  |
| POST   | `/admin/members`                           | Store new member                     |
| POST   | `/admin/members/{id}/update-plan`          | Update member plan                   |
| POST   | `/admin/members/{id}/toggle-block`         | Block / Unblock a member             |
| POST   | `/admin/members/{id}/activate`             | Activate a pending member            |
| POST   | `/admin/members/{id}/delete`               | Delete a member permanently          |
| POST   | `/admin/members/{id}/assign-workout`       | Assign workout program to member     |
| POST   | `/admin/members/{id}/assign-diet`          | Assign diet plan to member           |
| GET    | `/admin/report/download`                   | Download members CSV report          |
| POST   | `/member/toggle-exercise`                  | AJAX: toggle exercise completion     |
| POST   | `/member/toggle-meal`                      | AJAX: toggle meal logged             |
| POST   | `/member/check-in`                         | AJAX: daily gym check-in             |

---

## 🤝 Contributing

1. **Fork** the repository
2. **Create** a feature branch: `git checkout -b feature/your-feature-name`
3. **Commit** your changes: `git commit -m "feat: describe your change"`
4. **Push** to the branch: `git push origin feature/your-feature-name`
5. **Open** a Pull Request

---

## 📄 License

This project is licensed under the [MIT License](LICENSE).

---

<div align="center">

**Built with 💪 by the PulseForce Team**

</div>
