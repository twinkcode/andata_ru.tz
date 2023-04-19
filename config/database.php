<?php
/**
 * Настройки конфигурации БД
 * поддерживаются sqlite и mysql
 */

return [
    'default' => 'sqlite',

    'connections' => [
        'sqlite' => [
            'driver' => 'sqlite',
            'database' => realpath(__DIR__ . '/../database/andata_db.sqlite'),
            'prefix' => '',
        ],

        'mysql' => [
            'driver' => 'mysql',
            'host' => 'localhost',
            'database' => 'mydatabase',
            'username' => 'myusername',
            'password' => 'mypassword',
            'charset' => 'utf8mb4',
            'collation' => 'utf8mb4_unicode_ci',
            'prefix' => '',
        ],
    ],
];
