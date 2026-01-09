<?php
$users = [
    'admin' => [
        'hash' => password_hash('admin123', PASSWORD_DEFAULT),
        'role' => 'admin'
    ],
    'student' => [
        'hash' => password_hash('student123', PASSWORD_DEFAULT),
        'role' => 'user'
    ]
];
