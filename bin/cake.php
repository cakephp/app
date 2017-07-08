#!/usr/bin/php -q
<?php
// Check PHP version from composer.json, or default value.
$minVersion = '5.6.0';
if (file_exists('composer.json')) {
    $composer = json_decode(file_get_contents('composer.json'));
    if (isset($composer->require->php)) {
        $minVersion = preg_replace('/([^0-9\.])/', '', $composer->require->php);
    }
}
if (version_compare(phpversion(), $minVersion, '<')) {
    fwrite(STDERR, sprintf("Minimum PHP version: %s. You are using: %s.\n", $minVersion, phpversion()));
    exit(-1);
}

require dirname(__DIR__) . '/vendor/autoload.php';

use App\Application;
use Cake\Console\CommandRunner;

// Build the runner with an application and root executable name.
$runner = new CommandRunner(new Application(dirname(__DIR__) . '/config'), 'cake');
exit($runner->run($argv));
