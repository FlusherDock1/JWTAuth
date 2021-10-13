<?php

return [
    'default' => [
        'guard' => 'api',
    ],
    'guards' => [
        'api' => [
            'driver'   => 'jwt',
            'provider' => 'users',
        ],
    ],
];
