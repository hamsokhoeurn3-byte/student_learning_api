<?php

namespace Database\Seeders\Support;

/**
 * Single source of truth for the demo data used by the SLAS seeders.
 *
 * `base` / `trend` / `attendance` drive the generated learning data so each
 * demo student tells a different, believable story:
 *   base        average ability (0-100) in the first seeded semester
 *   trend       change of that ability per semester (negative = declining)
 *   attendance  attendance probability (%) in the first seeded semester
 */
final class DemoRoster
{
    public const PASSWORD = '12345678';

    /** Semesters that receive generated learning data: [academic year name, semester number]. */
    public const DATA_SEMESTERS = [
        ['2025-2026', 1],
        ['2025-2026', 2],
        ['2026-2027', 1],
    ];

    public static function departments(): array
    {
        return [
            ['code' => 'CS', 'name' => 'Computer Science', 'description' => 'Software, algorithms, data and computing theory.'],
            ['code' => 'IT', 'name' => 'Information Technology', 'description' => 'Networks, web, mobile and security technologies.'],
            ['code' => 'BA', 'name' => 'Business Administration', 'description' => 'Management, marketing and entrepreneurship.'],
        ];
    }

    public static function admin(): array
    {
        return [
            'email' => 'admin@slas.com',
            'name' => 'Admin SLAS',
            'admin_code' => 'ADM001',
            'first_name' => 'SLAS',
            'last_name' => 'Administrator',
            'department' => 'Administration',
            'position' => 'System Administrator',
        ];
    }

    public static function teachers(): array
    {
        return [
            ['code' => 'TCH001', 'email' => 'teacher@slas.com', 'first' => 'Emily', 'last' => 'Johnson', 'gender' => 'Female', 'dept' => 'CS', 'position' => 'Lecturer', 'specialization' => 'Data Structures'],
            ['code' => 'TCH002', 'email' => 'tch002@slas.com', 'first' => 'Michael', 'last' => 'Chen', 'gender' => 'Male', 'dept' => 'CS', 'position' => 'Senior Lecturer', 'specialization' => 'Databases'],
            ['code' => 'TCH003', 'email' => 'tch003@slas.com', 'first' => 'Sophia', 'last' => 'Martinez', 'gender' => 'Female', 'dept' => 'IT', 'position' => 'Lecturer', 'specialization' => 'Networking'],
            ['code' => 'TCH004', 'email' => 'tch004@slas.com', 'first' => 'David', 'last' => 'Kim', 'gender' => 'Male', 'dept' => 'IT', 'position' => 'Assistant Professor', 'specialization' => 'Mobile Development'],
        ];
    }

    public static function students(): array
    {
        return [
            ['code' => 'STD001', 'email' => 'student@slas.com', 'first' => 'Sok', 'last' => 'Dara', 'gender' => 'Male', 'dept' => 'CS', 'level' => 3, 'major' => 'Software Engineering', 'dob' => '2004-05-14', 'base' => 82, 'trend' => 2, 'attendance' => 92],
            ['code' => 'STD002', 'email' => 'std002@slas.com', 'first' => 'Chan', 'last' => 'Sophea', 'gender' => 'Female', 'dept' => 'CS', 'level' => 3, 'major' => 'Software Engineering', 'dob' => '2004-08-02', 'base' => 90, 'trend' => 0, 'attendance' => 97],
            ['code' => 'STD003', 'email' => 'std003@slas.com', 'first' => 'Vannak', 'last' => 'Rith', 'gender' => 'Male', 'dept' => 'CS', 'level' => 2, 'major' => 'Data Science', 'dob' => '2005-01-21', 'base' => 72, 'trend' => -9, 'attendance' => 88],
            ['code' => 'STD004', 'email' => 'std004@slas.com', 'first' => 'Srey', 'last' => 'Mom', 'gender' => 'Female', 'dept' => 'CS', 'level' => 2, 'major' => 'Data Science', 'dob' => '2005-03-30', 'base' => 58, 'trend' => 5, 'attendance' => 78],
            ['code' => 'STD005', 'email' => 'std005@slas.com', 'first' => 'Kosal', 'last' => 'Meas', 'gender' => 'Male', 'dept' => 'CS', 'level' => 3, 'major' => 'Software Engineering', 'dob' => '2004-11-09', 'base' => 52, 'trend' => -4, 'attendance' => 68],
            ['code' => 'STD006', 'email' => 'std006@slas.com', 'first' => 'Dalin', 'last' => 'Heng', 'gender' => 'Female', 'dept' => 'CS', 'level' => 2, 'major' => 'Artificial Intelligence', 'dob' => '2005-06-17', 'base' => 76, 'trend' => 1, 'attendance' => 90],
            ['code' => 'STD007', 'email' => 'std007@slas.com', 'first' => 'Pisey', 'last' => 'Nguon', 'gender' => 'Female', 'dept' => 'IT', 'level' => 3, 'major' => 'Network Engineering', 'dob' => '2004-02-25', 'base' => 85, 'trend' => 1, 'attendance' => 95],
            ['code' => 'STD008', 'email' => 'std008@slas.com', 'first' => 'Rithy', 'last' => 'Ouk', 'gender' => 'Male', 'dept' => 'IT', 'level' => 2, 'major' => 'Web Development', 'dob' => '2005-09-12', 'base' => 68, 'trend' => -2, 'attendance' => 84],
            ['code' => 'STD009', 'email' => 'std009@slas.com', 'first' => 'Sreyneath', 'last' => 'Lim', 'gender' => 'Female', 'dept' => 'IT', 'level' => 2, 'major' => 'Mobile Development', 'dob' => '2005-04-05', 'base' => 63, 'trend' => 6, 'attendance' => 82],
            ['code' => 'STD010', 'email' => 'std010@slas.com', 'first' => 'Bunthoeun', 'last' => 'Kem', 'gender' => 'Male', 'dept' => 'IT', 'level' => 2, 'major' => 'Cybersecurity', 'dob' => '2005-07-28', 'base' => 55, 'trend' => -6, 'attendance' => 66],
        ];
    }

    /** `slot` is the teaching time slot index used for the attendance sessions. */
    public static function courses(): array
    {
        return [
            ['code' => 'CS101', 'name' => 'Programming Fundamentals', 'dept' => 'CS', 'teacher' => 'TCH001', 'credit' => 3, 'slot' => 0, 'description' => 'Introduction to programming logic, control flow and basic problem solving.'],
            ['code' => 'CS201', 'name' => 'Data Structures and Algorithms', 'dept' => 'CS', 'teacher' => 'TCH001', 'credit' => 4, 'slot' => 1, 'description' => 'Lists, stacks, queues, trees, graphs and algorithm analysis.'],
            ['code' => 'CS301', 'name' => 'Database Systems', 'dept' => 'CS', 'teacher' => 'TCH002', 'credit' => 3, 'slot' => 2, 'description' => 'Relational modelling, SQL, normalization and transactions.'],
            ['code' => 'CS302', 'name' => 'Software Engineering', 'dept' => 'CS', 'teacher' => 'TCH002', 'credit' => 3, 'slot' => 3, 'description' => 'Software lifecycle, agile practices, testing and version control.'],
            ['code' => 'IT101', 'name' => 'Networking Fundamentals', 'dept' => 'IT', 'teacher' => 'TCH003', 'credit' => 3, 'slot' => 0, 'description' => 'OSI model, IP addressing, routing and network services.'],
            ['code' => 'IT201', 'name' => 'Web Development', 'dept' => 'IT', 'teacher' => 'TCH003', 'credit' => 4, 'slot' => 1, 'description' => 'HTML, CSS, JavaScript and building REST-backed web applications.'],
            ['code' => 'IT301', 'name' => 'Information Security', 'dept' => 'IT', 'teacher' => 'TCH004', 'credit' => 3, 'slot' => 2, 'description' => 'Threats, cryptography, authentication and secure system design.'],
            ['code' => 'IT302', 'name' => 'Mobile Application Development', 'dept' => 'IT', 'teacher' => 'TCH004', 'credit' => 3, 'slot' => 3, 'description' => 'Building Android apps that consume REST APIs.'],
        ];
    }

    /** question, options A-D, correct letter. Re-used by every course of the department. */
    public static function questionBank(string $departmentCode): array
    {
        $banks = [
            'CS' => [
                ['Which data structure operates on a Last-In, First-Out (LIFO) principle?', 'Queue', 'Stack', 'Linked list', 'Binary tree', 'B'],
                ['What is the time complexity of binary search on a sorted array of n elements?', 'O(n)', 'O(n log n)', 'O(log n)', 'O(1)', 'C'],
                ['Which SQL clause is used to filter groups after aggregation?', 'WHERE', 'GROUP BY', 'HAVING', 'ORDER BY', 'C'],
                ['Which OOP concept lets a subclass provide its own implementation of an inherited method?', 'Encapsulation', 'Overriding', 'Overloading', 'Abstraction', 'B'],
                ['What does ACID stand for in database transactions?', 'Atomicity, Consistency, Isolation, Durability', 'Accuracy, Control, Integrity, Data', 'Atomicity, Concurrency, Isolation, Dependency', 'Association, Consistency, Integrity, Durability', 'A'],
                ['Which sorting algorithm uses divide and conquer with O(n log n) average time?', 'Bubble sort', 'Insertion sort', 'Merge sort', 'Selection sort', 'C'],
                ['Which statement is NOT a value of the Agile Manifesto?', 'Individuals and interactions over processes and tools', 'Working software over comprehensive documentation', 'Following a plan over responding to change', 'Customer collaboration over contract negotiation', 'C'],
                ['What is the main purpose of a primary key in a relational table?', 'Speed up every query', 'Uniquely identify each row', 'Store large text values', 'Link to another database', 'B'],
                ['Which binary tree traversal visits left subtree, root, then right subtree?', 'Pre-order', 'Post-order', 'In-order', 'Level-order', 'C'],
                ['Which Git command creates a new branch and switches to it?', 'git branch -d', 'git checkout -b', 'git merge', 'git commit -a', 'B'],
            ],
            'IT' => [
                ['Which OSI layer is responsible for routing packets between networks?', 'Data Link', 'Transport', 'Network', 'Session', 'C'],
                ['What is the default port number for HTTPS?', '80', '443', '21', '8080', 'B'],
                ['Which HTTP method is normally used to create a new resource in a REST API?', 'GET', 'DELETE', 'POST', 'HEAD', 'C'],
                ['Which attack tricks users into entering credentials on a fake login page?', 'DDoS', 'Phishing', 'SQL injection', 'Port scanning', 'B'],
                ['Which CSS property controls the space between an element\'s border and its content?', 'margin', 'padding', 'spacing', 'outline', 'B'],
                ['Which protocol translates domain names into IP addresses?', 'DHCP', 'FTP', 'DNS', 'SMTP', 'C'],
                ['In Android, which component represents a single screen with a user interface?', 'Service', 'Activity', 'BroadcastReceiver', 'ContentProvider', 'B'],
                ['Which option is an example of two-factor authentication?', 'Password and security question', 'Password and a one-time code sent to a phone', 'Two different passwords', 'Username and email address', 'B'],
                ['What does JSON stand for?', 'JavaScript Object Notation', 'Java Standard Output Network', 'JavaScript Online Node', 'Joint Syntax Object Name', 'A'],
                ['Which subnet mask corresponds to a /24 network?', '255.0.0.0', '255.255.0.0', '255.255.255.0', '255.255.255.255', 'C'],
            ],
        ];

        return $banks[$departmentCode] ?? $banks['CS'];
    }
}
