<?php
/**
 * Test runner bootstrap.
 *
 * Add additional configuration/setup your application needs when running
 * unit tests in this file.
 */
use App\Application;

require dirname(__DIR__) . '/vendor/autoload.php';

$app = new Application(dirname(__DIR__) . '/config');
$app->bootstrap();
$_SERVER['PHP_SELF'] = '/';
