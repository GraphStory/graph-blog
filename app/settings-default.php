<?php
/*
 * You should make a copy of this bad boy and name it "settings.php"
 */

return [
    'settings' => [
        // View settings
        'view' => [
            'template_path' => __DIR__ . '/templates',
            'twig' => [
                'cache' => __DIR__ . '/../cache/twig',
                'debug' => true,
                'auto_reload' => true,
            ],
        ],

        // monolog settings
        'logger' => [
            'name' => 'app',
            'path' => __DIR__ . '/../log/app.log',
        ],

        // neo4j settings
        'neo4j' => [
            'alias' => 'default',
            'host' => 'localhost',
            'port' => 7474,
            'protocol' => 'http',
            'authmode' => false,
            'username' => null,
            'password' => null,
        ]
    ],
];
