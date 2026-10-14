# Student Learning API

Laravel REST API backend for the Student Learning Management System. The system supports authentication, role-based access, course management, teacher assignments, student enrollment, assignments, attendance, grades, and academic reports.

## Table of Contents

- [Project Overview](#project-overview)
- [Requirements](#requirements)
- [1. Clone the Projects](#1-clone-the-projects)
- [2. Install Backend Dependencies](#2-install-backend-dependencies)
- [3. Configure the Environment](#3-configure-the-environment)
- [4. Create and Configure the Database](#4-create-and-configure-the-database)
- [5. Run Migrations](#5-run-migrations)
- [6. Start the Laravel API](#6-start-the-laravel-api)
- [7. Connect Flutter to the API](#7-connect-flutter-to-the-api)
- [8. Test the API](#8-test-the-api)
- [9. Run the Flutter App](#9-run-the-flutter-app)
- [10. Git Workflow](#10-git-workflow)
- [11. Troubleshooting](#11-troubleshooting)

## Project Overview

This project consists of two separate repositories:

| Project | Repository |
|---|---|
| Laravel API backend | https://github.com/try-sothai/student_learning_api |
| Flutter frontend | https://github.com/try-sothai/student_learning_analytics |

The Laravel backend provides API endpoints, handles business logic, and communicates with the MySQL database. The Flutter application calls the API to display and manage student learning data.

## Requirements

Install the following tools before starting:

- PHP and Composer
- MySQL and phpMyAdmin, or WAMP
- Git
- Flutter SDK
- Dart SDK (included with Flutter)
- Android Studio or VS Code
- An Android emulator or physical Android device

Verify your installations:

```bash
php -v
composer --version
git --version
flutter --version
flutter doctor
```

## 1. Clone the Projects

Open a terminal in VS Code and navigate to the folder where you want to store your projects.

Clone the Laravel backend:

```bash
git clone https://github.com/try-sothai/student_learning_api.git
cd student_learning_api
```

Clone the Flutter frontend separately:

```bash
cd ..
git clone https://github.com/try-sothai/student_learning_analytics.git
```

Your folder structure should look similar to this:

```text
YourProjects/
├── student_learning_api/
│   ├── app/
│   ├── routes/
│   │   └── api.php
│   ├── database/
│   ├── .env.example
│   └── composer.json
│
└── student_learning_analytics/
    ├── lib/
    ├── android/
    ├── pubspec.yaml
    └── README.md
```

Note: The exact folder structure may differ depending on your current project files.

## 2. Install Backend Dependencies

Open the terminal inside the `student_learning_api` directory.

Install the PHP dependencies:

```bash
composer install
```

If your project does not have a `.env` file, create one.

**Windows Command Prompt:**

```cmd
copy .env.example .env
```

**PowerShell:**

```powershell
Copy-Item .env.example .env
```

Generate the Laravel application key:

```bash
php artisan key:generate
```

Do not generate a new application key every time you start the project. Keep your local key in your local `.env` file.

## 3. Configure the Environment

Open the backend `.env` file and configure the application and database settings.

Example:

```dotenv
APP_NAME="Student Learning API"
APP_ENV=local
APP_DEBUG=true
APP_URL=http://127.0.0.1:8000

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=student_learning_api
DB_USERNAME=root
DB_PASSWORD=
```

Adjust the database username, password, and port to match your local MySQL configuration.

If your database has a password, enter it in `DB_PASSWORD`.

**Important:** Never commit your `.env` file to GitHub. It may contain passwords, API keys, and other private settings.

After changing the environment configuration, clear Laravel's cached configuration:

```bash
php artisan config:clear
```

## 4. Create and Configure the Database

You can use phpMyAdmin through WAMP or another MySQL installation.

1. Start the MySQL service.
2. Open phpMyAdmin in your browser.
3. Create a database named `student_learning_analytics`.
4. Set the database connection details in the backend `.env` file.
5. Confirm that the database name, username, password, and port match your MySQL configuration.

The database name in this example must match `DB_DATABASE` in `.env`.

If your project already uses a different database name, keep the existing name or update both locations consistently.

## 5. Run Migrations

From the backend directory, run:

```bash
php artisan migrate
```

This creates the database tables defined by the Laravel migration files.

If your project provides database seeders and you need the initial development data, you can run:

```bash
php artisan db:seed
```

Only run the seeder if the project contains the required seeders and you understand what data they insert.

**Warning:** Avoid running `php artisan migrate:fresh` on a database containing data you need. This command drops existing tables before recreating them.

## 6. Start the Laravel API

Start the development server:

```bash
php artisan serve
```

By default, Laravel runs at:

```text
http://127.0.0.1:8000
```

The API base URL for a desktop application running on the same computer is:

```text
http://127.0.0.1:8000/api
```

Keep the Laravel terminal running while using the Flutter app.

### API routes

Check the routes available in your project:

```bash
php artisan route:list
```

To view API routes only, you can use:

```bash
php artisan route:list --path=api
```

Actual endpoints depend on the routes defined in `routes/api.php` and any additional route configuration in the project.

## 7. Connect Flutter to the API

The Flutter application must use the correct address to reach the Laravel backend.

### Choose the correct API base URL

| Flutter environment | API base URL |
|---|---|
| Flutter Web on the same computer | `http://127.0.0.1:8000/api` |
| Android emulator | `http://10.0.2.2:8000/api` |
| Physical Android phone on the same Wi-Fi | `http://YOUR_COMPUTER_IP:8000/api` |

**Important:** `127.0.0.1` inside an Android emulator refers to the emulator itself, not your computer. Use `10.0.2.2` to reach the host computer from the standard Android emulator.

### Find your computer's IP address

On Windows, open Command Prompt:

```cmd
ipconfig
```

Find the IPv4 address of the network adapter connected to the same Wi-Fi as your phone.

For example, if your computer's IPv4 address is `192.168.1.10`, your API base URL would be:

```text
http://192.168.1.10:8000/api
```

The address above is only an example. Replace it with your actual IPv4 address.

For a physical phone, you may need to allow incoming connections to the Laravel development server through Windows Firewall.

### Configure the Flutter API URL

Open the Flutter project:

```bash
cd ../student_learning_analytics
```

Find the file where your application defines its API base URL. It may be in `lib/`, a configuration folder, or a service file.

Set the base URL to the value appropriate for your device.

Example:

```dart
const String apiBaseUrl = 'http://10.0.2.2:8000/api';
```

This example is for the standard Android emulator. Use your actual configuration and avoid creating a second API constant if your project already has one.

Ensure that Flutter requests use the correct API endpoints, HTTP methods, request headers, and JSON body format defined by the Laravel backend.

### Android HTTP configuration

For local development, Android may block unencrypted HTTP traffic depending on your application configuration.

If you encounter a cleartext traffic error, review the Android network security settings in the Flutter project's `android/app/src/main/AndroidManifest.xml` and relevant Android configuration.

Allow cleartext HTTP only for development when necessary. For production, use HTTPS.

## 8. Test the API

Before testing Flutter login, confirm that the Laravel backend starts successfully.

Run:

```bash
php artisan route:list --path=api
```

Use the listed endpoints to test requests with Postman, another API client, or your Flutter application.

Check the following:

- The Laravel server is running.
- MySQL is running.
- The database connection works.
- The required tables exist.
- The requested API route is registered.
- Authentication headers and request data match the backend requirements.

The Laravel server's root URL is not necessarily an API endpoint. Test an actual route listed by your application.

## 9. Run the Flutter App

Open a second terminal and enter the frontend directory:

```bash
cd student_learning_analytics
```

Install Flutter dependencies:

```bash
flutter pub get
```

Check connected devices:

```bash
flutter devices
```

Start an emulator or connect your phone, then run:

```bash
flutter run
```

Keep the Laravel backend running in the first terminal.

If Flutter cannot connect to Laravel, verify the API base URL and make sure the phone or emulator can reach your computer.

## 10. Git Workflow

Use the following workflow to keep your code synchronized with GitHub.

### A. Check the current branch and changes

Run these commands inside the repository you want to update:

```bash
git status
git branch
git remote -v
```

The following examples assume your branch is named `main`. Replace `main` if your team uses a different branch.

### B. Pull the latest code

Before starting new work, save or commit your changes and then pull the latest version:

```bash
git pull origin main
```

If you have uncommitted changes, commit them or safely stash them before pulling. Resolve any merge conflicts before continuing.

### C. Push your changes to GitHub

After editing and testing your code:

```bash
git add .
git commit -m "Describe your changes"
git push origin main
```

Replace the commit message with a short description of your actual changes.

### D. Daily workflow

For the backend:

```bash
cd student_learning_api
git pull origin main

# Edit and test your code

git add .
git commit -m "Update backend API"
git push origin main
```

For the Flutter frontend, open a separate terminal:

```bash
cd student_learning_analytics
git pull origin main

# Edit and test your code

git add .
git commit -m "Update Flutter app"
git push origin main
```

**Important Git rules:**

- Pull the latest code before starting new work.
- Commit only changes that belong to the repository.
- Do not commit `.env`, passwords, private keys, or other secrets.
- Do not use `git push` until your changes have been reviewed and tested.
- Coordinate with your teammates when multiple people are working on the same branch.
- Backend and frontend changes must be pushed to their respective repositories.

## 11. Troubleshooting

### Composer installation fails

Check the PHP version and the requirements declared in `composer.json`.

```bash
php -v
composer check-platform-reqs
```

If dependencies require a newer PHP version than the one installed, configure a compatible PHP version before continuing.

### Database connection fails

Check the following settings in `.env`:

```dotenv
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=student_learning_analytics
DB_USERNAME=root
DB_PASSWORD=
```

Confirm that MySQL is running and that the database exists. Your credentials and port may differ.

Then run:

```bash
php artisan config:clear
php artisan migrate
```

### API returns a 404 error

Run:

```bash
php artisan route:list --path=api
```

Confirm that the endpoint exists and that the request uses the correct URL and HTTP method.

### Flutter cannot connect to Laravel

1. Confirm that Laravel is running.
2. Verify the API base URL for the current device.
3. Use `10.0.2.2` for the standard Android emulator.
4. Use your computer's IPv4 address for a physical phone on the same Wi-Fi.
5. Check Windows Firewall and Android network security settings if needed.

### Flutter dependencies fail

Run:

```bash
flutter doctor
flutter pub get
```

Resolve any reported