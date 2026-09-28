1. Clone Laravel Backend
cd /d D:\Development\Projects
git clone https://github.com/try-sothai/student_learning_api.git

2. Clone Flutter Frontend
cd /d D:\Development\Projects
git clone https://github.com/try-sothai/student_learning_analytics.git

បន្ទាប់ពី Clone Laravel
cd student_learning_api

Copy .env
copy .env.example .env

Install Package
composer install

Generate Key
php artisan key:generate

កំណត់ Database ក្នុង .env រួច Run
php artisan migrate

ចាប់ផ្តើម Server
php artisan serve

User accoount and password

Student: STD001 -STD301/ 12345678
Teacher: TCH001 / 12345678
Admin: ADM001 / 12345678

បន្ទាប់ពី Clone Flutter
cd student_learning_analytics

ទាញយក Package
flutter pub get

Run App
flutter run

បើធ្វើការជាក្រុម

ពេលសមាជិកក្រុមកែ Code រួច Push ទៅ GitHub ហើយ បងត្រូវទាញយកការកែប្រែចុងក្រោយដោយប្រើ៖
Laravel
cd student_learning_api
git pull origin main

Flutter
cd student_learning_analytics
git pull origin main

Backend
git clone https://github.com/try-sothai/student_learning_api.git
Frontend
git clone https://github.com/try-sothai/student_learning_analytics.git

សង្ខេប Git Commands ដែលបងត្រូវចាំ
បង្កើត Project ថ្មី (ធ្វើតែ ១ ដង)
git init
git add .
git commit -m "Initial project"
git branch -M main
git remote add origin <repository-url>
git push -u origin main

Push កូដថ្មី (ប្រើរាល់ថ្ងៃ)
git add .
git commit -m "Describe your changes"
git push

ទាញកូដថ្មីពី GitHub
git pull

<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework. You can also check out [Laravel Learn](https://laravel.com/learn), where you will be guided through building a modern Laravel application.

If you don't feel like reading, [Laracasts](https://laracasts.com) can help. Laracasts contains thousands of video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

## Laravel Sponsors

We would like to extend our thanks to the following sponsors for funding Laravel development. If you are interested in becoming a sponsor, please visit the [Laravel Partners program](https://partners.laravel.com).

### Premium Partners

- **[Vehikl](https://vehikl.com)**
- **[Tighten Co.](https://tighten.co)**
- **[Kirschbaum Development Group](https://kirschbaumdevelopment.com)**
- **[64 Robots](https://64robots.com)**
- **[Curotec](https://www.curotec.com/services/technologies/laravel)**
- **[DevSquad](https://devsquad.com/hire-laravel-developers)**
- **[Redberry](https://redberry.international/laravel-development)**
- **[Active Logic](https://activelogic.com)**

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).


The assignment workflow is in place:

Assign a teacher: In Admin → Courses, open a course and choose Edit. Select the teacher and save.
Assign students to a class: Open the course, select students under Enrolled students, and choose Enroll students.
Teacher roster: The assigned teacher’s Students page now lists students enrolled in their courses.
Student course list: Students see their real enrollments and published assignments under My Courses.