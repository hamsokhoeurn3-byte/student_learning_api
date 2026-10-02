# Student Learning API

A Laravel backend for the student learning management system. It includes authentication, role-based dashboards, course creation, teacher assignment, student enrollment, and assignment management for students, teachers, and admins.

## Project setup

### 1) Clone the backend

```bash
git clone https://github.com/try-sothai/student_learning_api.git
cd student_learning_api
```

### 2) Configure the environment

```bash
copy .env.example .env
composer install
php artisan key:generate
```

### 3) Set up the database

Update the database settings in `.env`, then run:

```bash
php artisan migrate
```

### 4) Start the server

```bash
php artisan serve
```

The app runs at:

```text
http://127.0.0.1:8000
```

## Default login accounts

```text
Student: STD001 - STD301 / 12345678
Teacher: TCH001 / 12345678
Admin: ADM001 / 12345678
```

## Class management workflow

Admins manage the course catalog and configure class assignments separately:

1. Add basic course information under Admin > Courses.
2. Open Admin > Assign Class to create a class setup from the course catalog.
3. Assign the teacher, select enrolled students, and set the schedule.
4. The assigned class and student roster appear in the teacher's Courses and Students pages.
5. The teacher creates file-upload or true/false assignments for their assigned classes. True/false questions are auto-graded; retakes can be enabled with a maximum attempt count.
6. Students enrolled in the selected class can submit a file or answer questions during the assignment's availability window.
7. The teacher records each enrolled student's attendance by class and date from the Attendance page.

## Role-based access

- Teachers see only courses and students assigned to them by an admin, and create assignments for those courses.
- Students see their enrolled courses and published assignments in My Courses.
- Admins manage the full class catalog, teachers, students, and assignments.

## Git workflow

```bash
git add .
git commit -m "Describe your changes"
git push
```

To pull the latest updates:

```bash
git pull origin main
```

## Frontend project

```bash
cd ..
git clone https://github.com/try-sothai/student_learning_analytics.git
cd student_learning_analytics
flutter pub get
flutter run
```
