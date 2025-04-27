<?php

$debug = $_ENV['DEBUG'];

// Should be set to 0 in production
error_reporting($debug != 'false' ? E_ALL : 0);

// Should be set to '0' in production
ini_set('display_errors', $debug != 'false' ? E_ALL : 0);
ini_set('error_log', '../log/' . date('Y-m-d') . '.log');

return [
    'twig' => [
        'templates_path' => __DIR__ . '/../templates/',
        'uploads' => [
            'base_path' => __DIR__ . '/../public/uploads/',
            'base_url' => '/uploads/',
            'profile_image_path' => __DIR__ . '/../public/uploads/profile_images/',
            'profile_image_url' => '/uploads/profile_images/',
        ],
    ],
    'migrations' => [
        'token' => $_ENV['SECURE_TOKEN'],
    ],
    'db' => [
        'user' => $_ENV['DB_USER'],
        'pass' => $_ENV['DB_PASS'],
        'host' => $_ENV['DB_HOST'],
        'charset' => $_ENV['CHARSET'],
        'name' => $_ENV['DB_NAME'],
    ],
    'error' => [
        // Should be set to false in production
        'display_error_details' => $_ENV['DEBUG'] == 'true',
        // Parameter is passed to the default ErrorHandler
        // View in rendered output by enabling the "displayErrorDetails" setting.
        // For the console and unit tests we also disable it
        'log_errors' => true,
        // Display error details in error log
        'log_error_details' => true,
    ]
];
