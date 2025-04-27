<?php

declare(strict_types=1);

use Src\Application\Settings\SettingsInterface;
use DI\ContainerBuilder;
use Monolog\Logger;
use Src\Application\Settings\Settings;

return function (ContainerBuilder $containerBuilder) {

    // Global Settings Object
    $containerBuilder->addDefinitions([
        SettingsInterface::class => function () {
            return new Settings([
                'displayErrorDetails' => true, // Should be set to false in production
                'logError'            => false,
                'logErrorDetails'     => false,
                'logger' => [
                    'name' => 'slim-app',
                    'path' => isset($_ENV['docker']) ? 'php://stdout' : __DIR__ . '/../logs/app.log',
                    'level' => Logger::DEBUG,
                ],
                'db' => [
                    'host' => $_ENV['DB_HOST'] ?? 'localhost',
                    'name' => $_ENV['DB_NAME'] ?? 'database',
                    'user' => $_ENV['DB_USER'] ?? 'user',
                    'pass' => $_ENV['DB_PASS'] ?? 'password',
                    'charset' => $_ENV['DB_CHARSET'] ?? 'utf8mb4',
                ],
            ]);
        }
    ]);
};
