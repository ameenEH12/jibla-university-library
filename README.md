# Jibla University e-Library

A web-based electronic library designed to help Jibla University students and faculty members access, organize, and manage academic learning materials in one place.

## About the Project

**Jibla University e-Library** is an academic resource platform built with Laravel. It provides a centralized environment for organizing educational content and making learning resources easier to access.

The project aims to support digital learning by organizing academic materials, books, and subjects through a web-based interface.

## Features

- **Authentication:** User authentication with Google sign-in integration.
- **Role-Based Access:** Support for different user roles, including administrators, doctors, and students.
- **Academic Departments:** Organize academic content by departments and subjects.
- **Digital Library:** Manage and access books and educational materials.
- **File Management:** Upload and organize academic resources.
- **Search:** Find relevant educational content.
- **User Management:** Administrative tools for managing users and academic resources.

## Technology Stack

- **Backend:** Laravel 12
- **Programming Language:** PHP 8.2+
- **Database:** Configurable through Laravel's database configuration
- **Frontend:** Blade templates, HTML, CSS, and JavaScript
- **Dependency Management:** Composer and npm
- **Authentication:** Laravel authentication with Google sign-in integration

## Requirements

Before installing the project, ensure that you have:

- PHP 8.2 or later
- Composer
- Node.js and npm
- A supported database, such as MySQL or SQLite
- Git

## Installation

### 1. Clone the Repository

```bash
git clone https://github.com/ameenEH12/jibla-university-library.git
cd REPOSITORY
```


### 2. Install PHP Dependencies

```bash
composer install
```

### 3. Configure Environment Variables

Create your local environment file:

```bash
cp .env.example .env
```

On Windows PowerShell, use:

```powershell
Copy-Item .env.example .env
```

Configure the database connection and other required settings in `.env`.

**Never commit your `.env` file or publish private credentials.**

### 4. Generate the Application Key

```bash
php artisan key:generate
```

### 5. Configure the Database

Set your database connection details in `.env`.

Run the migrations:

```bash
php artisan migrate
```

Run seeders only if required by your local setup:

```bash
php artisan db:seed
```

### 6. Install Frontend Dependencies

```bash
npm install
```

Build the frontend assets:

```bash
npm run build
```

### 7. Configure Google Sign-In

If Google sign-in is required, configure the appropriate Google OAuth credentials in your local `.env` file.

Set the authorized redirect URI in the Google Cloud project to match the callback route configured by the application.

Do not publish OAuth client secrets or other private credentials.

### 8. Start the Development Server

```bash
php artisan serve
```

Open the local URL displayed by Laravel, typically:

```text
http://127.0.0.1:8000
```

## Project Structure

```text
app/
├── Http/
│   └── Controllers/
├── Models/
└── Providers/

bootstrap/
config/
database/
├── factories/
├── migrations/
└── seeders/

public/
├── images/
└── index.php

resources/
├── css/
├── js/
└── views/

routes/
storage/
tests/
```

## Security

- Keep `.env` and all private credentials out of version control.
- Never publish OAuth client secrets, API keys, or private keys.
- Keep uploaded books and other private or user-provided files out of the public source repository unless publication is explicitly intended.
- Configure production environment variables securely.
- Review access permissions before deploying the application.

## Project Status

This project is under development. Features and installation requirements may evolve as development continues.

## Contributing

Contributions, suggestions, and bug reports are welcome.

1. Fork the repository.
2. Create a feature branch.
3. Make your changes.
4. Test your changes.
5. Submit a pull request describing your contribution.

## License

No license has been specified yet. Until a license is added, the repository should not be assumed to grant permission to reuse, distribute, or modify its code.

## Acknowledgments

Developed as an academic project to support digital access to educational resources at Jibla University.