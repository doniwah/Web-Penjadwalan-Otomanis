# SiJadu (Sistem Informasi Jadwal Kuliah)

SiJadu is a web-based application for automatic course scheduling using a Genetic Algorithm, built with Laravel and Tailwind CSS.

## Features
-   **Automatic Scheduling**: Uses Genetic Algorithm to generate conflict-free schedules.
-   **Role-Based Access**: Admin, Lecturer, and Student dashboards.
-   **Soft Constraints**: Lecturers can specify preferred teaching days.
-   **Notifications**: Email notifications when schedules are published.
-   **Calendar View**: Weekly grid view of the schedule.

## Prerequisites
-   PHP 8.2+
-   Composer
-   Node.js & NPM

## Installation

1.  **Clone the repository** (if applicable) or navigate to the project directory.
2.  **Install PHP dependencies**:
    ```bash
    composer install
    ```
3.  **Install Node.js dependencies**:
    ```bash
    npm install
    ```
4.  **Setup Environment**:
    -   Copy `.env.example` to `.env`.
    -   Configure your database (SQLite is set up by default).
5.  **Generate Application Key**:
    ```bash
    php artisan key:generate
    ```
6.  **Run Migrations and Seed Data**:
    ```bash
    php artisan migrate --seed
    ```
    *Note: This will create dummy data including Lecturers and an Admin.*

## How to Run

1.  **Start the Laravel Development Server**:
    ```bash
    php artisan serve
    ```
    The app will be available at [http://127.0.0.1:8000](http://127.0.0.1:8000).

2.  **Start the Vite Development Server** (for Tailwind CSS):
    ```bash
    npm run dev
    ```
    *Keep this running in a separate terminal window.*

## Login Credentials (from Seeder)

-   **Admin**: You may need to create one manually via Tinker if not seeded.
    ```bash
    php artisan tinker
    >>> \App\Models\User::factory()->create(['name' => 'Admin', 'email' => 'admin@example.com', 'role' => 'admin', 'password' => bcrypt('password')]);
    ```
    -   Email: `admin@example.com`
    -   Password: `password`

-   **Lecturer**:
    -   Email: `lecturer1@example.com`
    -   Password: `password`

## Usage Guide

1.  **Login as Admin**.
2.  Go to **Generate Schedule** and click the button.
3.  Review the generated schedule.
4.  Click **Publish Schedule** to notify users.
5.  **Login as Lecturer** to set **Preferred Days** and view your personal schedule.
