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
