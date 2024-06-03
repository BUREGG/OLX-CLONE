<?php

return [
    'botman' => [
        'conversation_cache_time' => 30,
        'user_cache_time' => 30,
        'conversation_cache_driver' => 'file',
        'user_cache_driver' => 'file',
        'matching' => [
            'strict' => false,
        ],
        'web' => [
            'matchingData' => [
                'driver' => 'web',
            ],
        ],
    ],
];
