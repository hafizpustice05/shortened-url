# Laravel Project

## Introduction
This is a [Laravel](https://laravel.com/) project. To set it up and run locally, follow the instructions below.

## Prerequisites
Make sure you have the following installed on your machine:
- **PHP** (>= 8.0)
- **Composer** (Dependency Manager for PHP)
- **MySQL** or any supported database
- **Git** (optional, but recommended)

## Getting Started

### 1. Clone the Repository
To get started, clone the repository to your local machine:
```bash
git clone git@github.com:hafizpustice05/shortened-url.git
```

### 2. Install Dependencies
Run the following command to install PHP dependencies:

```bash
composer install
```

### 3. Set Up Environment Variables
Copy the .env.example file to .env:
```
cp .env.example .env
```
Open the .env file and configure your environment variables, particularly:

DB_CONNECTION
DB_HOST
DB_PORT
DB_DATABASE
DB_USERNAME
DB_PASSWORD
For example:

```bash
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=your-database-name
DB_USERNAME=your-username
DB_PASSWORD=your-password

```

### 4. Generate Application Key
Generate a new application key using the following command:

```bash
php artisan key:generate
```
This key is used to secure encrypted data within your application.

### 5. Set Up the Database
Ensure you have created a database in MySQL (or the database system you use). Then, run migrations to create the necessary database tables:

```bash
php artisan migrate
```

### 6. Run the Project
Option 1: Using Laravel's Built-In Development Server
Start the Laravel development server by running:

```bash
php artisan serve
```

By default, the project will be available at `http://127.0.0.1:8000`

# Troubleshooting

### 1. Composer Memory Issues
If you encounter memory limit errors during `composer install`, you can increase the memory limit temporarily by running:
```bash
php -d memory_limit=-1 /usr/local/bin/composer install
```
### 2. Common Issues
Permission Issues: Make sure `storage` and `bootstrap/cache` directories are writable by the web server.
```
chmod -R 775 storage
chmod -R 775 bootstrap/cache
```

## Contact

Md Hafizul Islam - [hafizpustice05@gmail.com](mailto:hafizpustice05@gmail.com)
