@include('components.portal.shell', [
    'theme' => 'payroll',
    'role' => 'Payroll Panel',
    'homeRoute' => 'payroll.dashboard',
    'profileRoute' => 'payroll.settings',
    'navItems' => [
        ['route' => 'payroll.dashboard', 'label' => 'Dashboard', 'icon' => 'speedometer2'],
        ['route' => 'payroll.employees', 'label' => 'Employees', 'icon' => 'people'],
        ['route' => 'payroll.salaries', 'label' => 'Salaries', 'icon' => 'cash-coin'],
        ['route' => 'payroll.runs', 'label' => 'Payroll Runs', 'icon' => 'calculator'],
        ['route' => 'payroll.allowances', 'label' => 'Allowances', 'icon' => 'plus-square'],
        ['route' => 'payroll.deductions', 'label' => 'Deductions', 'icon' => 'dash-square'],
        ['route' => 'payroll.payslips', 'label' => 'Payslips', 'icon' => 'receipt'],
        ['route' => 'payroll.reports', 'label' => 'Reports', 'icon' => 'bar-chart-line'],
        ['route' => 'payroll.settings', 'label' => 'Settings', 'icon' => 'gear'],
    ],
])
