<?php

if (! function_exists('tid')) {
	function tid() {
        return new \Ajtarragona\TID\Services\TIDService;
    }
}