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