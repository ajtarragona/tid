<?php
    return [
        
        'log' =>env('VALID_LOG', false),
        'test_mode' => env('TID_TEST_MODE', false),
        'environment' =>env('VALID_ENVIRONMENT', 'pre'),
        'paths'=>[
            'auth'=>'o/oauth2/auth',
            'token'=>'o/oauth2/token',
            'user'=>'serveis-rest/getUserInfo',
            'revoke'=>'o/oauth2/revoke',
            'logout'=>'o/oauth2/logout',
        ],
        'environments' =>[
            'pre'=>env('VALID_PRE_URL','https://valid-pre.aoc.cat'), //https://valid-pre.aoc.cat/o/oauth2 
            // [
            //     'base_url' =>'https://identitats-pre.aoc.cat', //https://valid-pre.aoc.cat/o/oauth2
            //     'auth_url' => 'https://identitats-pre.aoc.cat/o/oauth2/auth',
            //     'token_url' => 'https://identitats-pre.aoc.cat/o/oauth2/token',
            //     'user_url' => 'https://identitats-pre.aoc.cat/serveis-rest/getUserInfo',
            //     'revoke_url' => 'https://identitats-pre.aoc.cat/o/oauth2/revoke',
            //     'logout_url' => 'https://identitats-pre.aoc.cat/o/oauth2/logout',
                
            // ],
            'pro'=>env('VALID_PRO_URL','https://valid.aoc.cat'), //https://valid.aoc.cat/o/oauth2
            // [
            //     'base_url' =>'https://identitats.aoc.cat', //https://valid.aoc.cat/o/oauth2
            //     'auth_url' => 'https://identitats.aoc.cat/o/oauth2/auth',
            //     'token_url' => 'https://identitats.aoc.cat/o/oauth2/token',
            //     'user_url' => 'https://identitats.aoc.cat/serveis-rest/getUserInfo',
            //     'revoke_url' => 'https://identitats.aoc.cat/o/oauth2/revoke',
            //     'logout_url' => 'https://identitats.aoc.cat/o/oauth2/logout',
            // ]
        ],
        'client_id' => env('VALID_CLIENT_ID', 'xxx'),
        'client_secret' => env('VALID_CLIENT_SECRET', 'xxx'),
        'access_type' => env('VALID_ACCESS_TYPE', 'online'),
        'scope' => env('VALID_SCOPE', 'autenticacio_usuari'),
        'redirect_uri' => env('VALID_REDIRECT_URI', null),

    ];