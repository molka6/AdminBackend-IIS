<?php

use App\Kernel;

require_once dirname(__DIR__).'/vendor/autoload_runtime.php';

return function (array $context) {
    return new Kernel($context['APP_ENV'], (bool) $context['APP_DEBUG']);
};
$response->headers->set('Access-Control-Allow-Origin', '*');
$response->headers->set('Access-Control-Allow-Methods', 'GET,POST,PUT');
$response->headers->set('Access-Control-Allow-Headers', 'X-Header-One,X-Header-Two');

