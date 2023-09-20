<?php

if (! function_exists('tid')) {
	function tid() {
        return new \Ajtarragona\TID\Services\TIDService;
    }
}

if (! function_exists('validLoginForm')) {
	function validLoginForm($options=[]) {
        return tid()->renderLoginForm($options);
    }
}

if (! function_exists('validUserInfo')) {
	function validUserInfo($options=[]) {
        return tid()->renderUserInfo($options);
    }
}

if (! function_exists('validTokenInfo')) {
	function validTokenInfo($options=[]) {
        return tid()->renderTokenInfo($options);
    }
}

if (! function_exists('validLogoutButton')) {
	function validLogoutButton($options=[]) {
        return tid()->renderLogoutButton($options);
    }
}