@include('components.portal.shell', [
    'role' => 'Admin Panel',
    'homeRoute' => 'admin.dashboard',
    'navItems' => [
        ['route' => 'admin.dashboard', 'label' => 'Dashboard', 'icon' => 'grid-1x2-fill'],
        ['route' => 'admin.students', 'label' => 'Students', 'icon' => 'mortarboard'],
        ['route' => 'admin.teachers', 'label' => 'Teachers', 'icon' => 'person-workspace'],
        ['route' => 'admin.courses', 'label' => 'Courses', 'icon' => 'book'],
        ['route' => 'admin.assignments', 'label' => 'Assignments', 'icon' => 'journal-text'],
        ['route' => 'admin.reports', 'label' => 'Reports', 'icon' => 'bar-chart-line'],
        ['route' => 'admin.settings', 'label' => 'Settings', 'icon' => 'gear'],
    ],
])
