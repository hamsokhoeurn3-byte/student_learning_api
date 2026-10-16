@include('components.portal.shell', [
    'role' => 'Teacher Portal',
    'homeRoute' => 'teacher.dashboard',
    'profileRoute' => 'teacher.settings',
    'navItems' => [
        ['route' => 'teacher.students', 'label' => 'Students', 'icon' => 'people'],
        ['route' => 'teacher.attendance', 'label' => 'Attendance', 'icon' => 'calendar-check'],
        ['route' => 'teacher.assignments', 'label' => 'Assignments', 'icon' => 'journal-text'],
        ['route' => 'teacher.quizzes', 'label' => 'Quizzes', 'icon' => 'patch-question'],
        ['route' => 'teacher.grades', 'label' => 'Grades', 'icon' => 'clipboard-data'],
        ['route' => 'teacher.courses', 'label' => 'Courses', 'icon' => 'book'],
        ['route' => 'teacher.calendar', 'label' => 'Calendar', 'icon' => 'calendar3'],
        ['route' => 'teacher.reports', 'label' => 'Reports', 'icon' => 'bar-chart-line'],
        ['route' => 'teacher.settings', 'label' => 'Settings', 'icon' => 'gear'],
    ],
])
