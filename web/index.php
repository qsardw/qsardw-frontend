<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Qsardw\Frontend\Application;

define('APP_FOLDER', realpath(dirname(__FILE__) . DIRECTORY_SEPARATOR . '..'));
define('APP_PUBLIC_FOLDER', realpath(dirname(__FILE__)));
define('APP_CONFIG_FOLDER', APP_FOLDER . DIRECTORY_SEPARATOR . 'config');
define('APP_CACHE_FOLDER', '/var/cache/qsardw');
define('APP_LOGS_FOLDER', '/var/log/qsardw');

defined('APP_ENVIRONMENT') ||
    define(
        'APP_ENVIRONMENT',
        (getenv('APP_ENVIRONMENT') ? getenv('APP_ENVIRONMENT') : 'development')
    );

$app = new Application();

require __DIR__ . '/../config/prod.php';

if ('development' === APP_ENVIRONMENT) {
    require __DIR__ . '/../config/dev.php';
}

require __DIR__ . '/../src/app.php';
require __DIR__ . '/../src/controllers.php';

$app->run();
