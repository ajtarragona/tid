<?php
    return [
        
        'environment' =>env('VALID_ENVIROMENT', 'pre'),
        'environments' =>[
            'pre'=>[
                'auth_url' => 'https://identitats-pre.aoc.cat/o/oauth2/auth',
                'token_url' => 'https://identitats-pre.aoc.cat/o/oauth2/token',
                'user_url' => 'https://identitats-pre.aoc.cat/serveis-rest/getUserInfo',
                'logout_url' => 'https://identitats-pre.aoc.cat/o/oauth2/logout',

            ],
            'pro'=>[
                'auth_url' => 'https://identitats.aoc.cat/o/oauth2/auth',
                'token_url' => 'https://identitats.aoc.cat/o/oauth2/token',
                'user_url' => 'https://identitats.aoc.cat/serveis-rest/getUserInfo',
                'logout_url' => 'https://identitats.aoc.cat/o/oauth2/logout',
            ]
        ],
        'client_id' => env('VALID_CLIENT_ID', 'xxx'),
        'client_secret' => env('VALID_CLIENT_SECRET', 'xxx'),
        'access_type' => env('VALID_ACCESS_TYPE', 'online'),
        'scope' => env('VALID_SCOPE', 'autenticacio_usuari'),
        'redirect_uri' => env('VALID_REDIRECT_URI', null),

    ];