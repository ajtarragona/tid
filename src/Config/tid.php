<?php
    return [
        
        'log' =>env('VALID_LOG', false),
        'test_mode' => env('TID_TEST_MODE', false),
        'environment' =>env('VALID_ENVIRONMENT', 'pre'),
        'environments' =>[
            'pre'=>[
                'auth_url' => 'https://identitats-pre.aoc.cat/o/oauth2/auth',
                'token_url' => 'https://identitats-pre.aoc.cat/o/oauth2/token',
                'user_url' => 'https://identitats-pre.aoc.cat/serveis-rest/getUserInfo',
                'revoke_url' => 'https://identitats-pre.aoc.cat/o/oauth2/revoke',
                'logout_url' => 'https://identitats-pre.aoc.cat/o/oauth2/logout',
                
            ],
            'pro'=>[
                'auth_url' => 'https://identitats.aoc.cat/o/oauth2/auth',
                'token_url' => 'https://identitats.aoc.cat/o/oauth2/token',
                'user_url' => 'https://identitats.aoc.cat/serveis-rest/getUserInfo',
                'revoke_url' => 'https://identitats.aoc.cat/o/oauth2/revoke',
                'logout_url' => 'https://identitats.aoc.cat/o/oauth2/logout',
            ]
        ],
        'client_id' => env('VALID_CLIENT_ID', 'xxx'),
        'client_secret' => env('VALID_CLIENT_SECRET', 'xxx'),
        'access_type' => env('VALID_ACCESS_TYPE', 'online'),
        'scope' => env('VALID_SCOPE', 'autenticacio_usuari'),
        'redirect_uri' => env('VALID_REDIRECT_URI', null),

    ];